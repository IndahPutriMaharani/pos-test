@extends('layout.app')

<div id="alert-container"
     class="position-fixed top-0 end-0 p-3"
     style="z-index: 1100">
</div>

@section('content')
<div class="row">

    <!-- kiri all menu -->
    <div class="col-md-8">
        <div class="row">

            @foreach($menus as $menu)
            <div class="col-md-3 mb-3">
                <div class="card h-100 text-center shadow-sm menu-card"
                     style="cursor:pointer"
                     data-id="{{ $menu->id }}"
                     data-name="{{ $menu->name }}"
                     data-price="{{ $menu->price }}">

                    <img src="{{ asset($menu->image) }}"
                         class="card-img-top"
                         style="height:120px; object-fit:cover">

                    <div class="card-body p-2">
                        <h6 class="mb-1">{{ $menu->name }}</h6>
                        <small class="text-muted">
                            Rp {{ number_format($menu->price) }}
                        </small>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

    <!-- kanan transkasi yang dipilih -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="mb-3 text-center">Pesanan</h5>

                <!-- listnya  -->
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="bill-items">
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                Belum ada pesanan
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span id="total-price" class="text-success">Rp 0</span>
                </div>
                <hr>

                <div class="d-grid gap-2">
                    <button id="btn-save" class="btn btn-secondary" disabled>
                        Save Bill
                    </button>
                    <button id="btn-print" class="btn btn-warning" disabled>
                        Print Bill
                    </button>
                    <button id="btn-charge" class="btn btn-success" disabled>
                        Charge
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="chargeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Charge</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Total Charge: <strong id="charge-total">Rp 0</strong></p>

        <div class="mb-3">
            <label>Uang Pembeli</label>
            <input type="number" id="cash" class="form-control">
        </div>

        <p>Kembalian: <strong id="change">Rp 0</strong></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onclick="confirmCharge()">OK</button>
      </div>
    </div>
  </div>
</div>


<script>
let cart = {};

document.querySelectorAll('.menu-card').forEach(card => {
    card.addEventListener('click', function () {
        const id    = this.dataset.id;
        const name  = this.dataset.name;
        const price = parseInt(this.dataset.price);

        if (cart[id]) {
            cart[id].qty++;
        } else {
            cart[id] = {
                name: name,
                price: price,
                qty: 1
            };
        }

        renderBill();
    });
});

function renderBill() {
    const tbody = document.getElementById('bill-items');
    tbody.innerHTML = '';

    let total = 0;
    let empty = true;

    for (const id in cart) {
        empty = false;
        const item = cart[id];
        const subtotal = item.qty * item.price;
        total += subtotal;

        tbody.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td class="text-center">x${item.qty}</td>
                <td class="text-end">Rp ${subtotal.toLocaleString()}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger"
                        onclick="removeItem(${id})">
                        ✕
                    </button>
                </td>
            </tr>
        `;
    }

    if (empty) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center text-muted">
                Belum ada pesanan
                </td>
            </tr>
        `;
    }

    document.getElementById('total-price').innerText =
        'Rp ' + total.toLocaleString();

    document.getElementById('btn-save').disabled   = empty;
    document.getElementById('btn-print').disabled = empty;
    document.getElementById('btn-charge').disabled = empty;

    window.currentTotal = total;
}

function removeItem(id) {
    delete cart[id];
    renderBill();
}
</script>


<script>
document.getElementById('btn-save').onclick = function () {
    showAlert('Bill berhasil disimpan');
};
</script>

<script>
document.getElementById('btn-print').onclick = function () {
    window.print();
};
</script>

<script>
    document.getElementById('btn-charge').onclick = function () {
        document.getElementById('charge-total').innerText =
            'Rp ' + window.currentTotal.toLocaleString();

        document.getElementById('cash').value = '';
        document.getElementById('change').innerText = 'Rp 0';

        new bootstrap.Modal(document.getElementById('chargeModal')).show();
    };

    document.getElementById('cash').addEventListener('input', function () {
        let cash = parseInt(this.value) || 0;
        let change = cash - window.currentTotal;

        document.getElementById('change').innerText =
            'Rp ' + (change > 0 ? change : 0).toLocaleString();
    });

    function confirmCharge() {
        showAlert('Transaksi berhasil', 'success');

        cart = {};
        renderBill();

        bootstrap.Modal.getInstance(
            document.getElementById('chargeModal')
        ).hide();
    }
</script>

<script>
    function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alert-container');

    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show shadow`;
    alert.role = 'alert';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    alertContainer.appendChild(alert);

    // auto close setelah 3 detik
    setTimeout(() => {
        alert.classList.remove('show');
        alert.classList.add('hide');
        setTimeout(() => alert.remove(), 300);
    }, 3000);
}
</script>

<style>
.menu-card:hover {
    transform: scale(1.03);
    transition: 0.2s;
    box-shadow: 0 90px 18px rgba(0,0,0,0.15);
}
</style>
@endsection


