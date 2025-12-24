@extends('layout.app')

@section('content')
<div class="container-fluid mt-3">

    <div id="alert-container"
        class="position-fixed top-0 end-0 p-3"
        style="z-index:1100">
    </div>

    <div id="app">
        <div class="row">
            <!-- kiri all menu -->
            <div class="col-md-8">
                <div class="row">
                    @foreach($menus as $menu)
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 text-center shadow-sm menu-card border-0"
                            style="cursor:pointer"
                            @click="addItem({
                                id: {{ $menu->id }},
                                name: '{{ $menu->name }}',
                                price: {{ $menu->price }}
                            })">

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
                            <tbody>
                            <tr v-if="isEmpty">
                                <td colspan="4" class="text-center text-muted">
                                    Klik menu di kiri untuk menambahkan pesanan
                                </td>
                            </tr>

                            <tr v-for="(item, id) in cart" :key="id">
                                <td>@{{ item.name }}</td>
                                <td class="text-center">x@{{ item.qty }}</td>
                                <td class="text-end">
                                    Rp @{{ (item.qty * item.price).toLocaleString() }}
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger"
                                            @click="removeItem(id)">
                                        ✕
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span class="text-success">
                                Rp @{{ total.toLocaleString() }}
                            </span>
                        </div>
                        <hr>

                        <div class="d-grid gap-2">
                            <button id="btn-save" class="btn btn-secondary" disabled>
                                Save Bill
                            </button>
                            <button class="btn btn-outline-secondary" @click="printReceipt">
                                Print Bill
                            </button>
                            <button class="btn btn-success fw-bold"
                                    :disabled="isEmpty"
                                    @click="openCharge">
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
                <p>
                    Total Belanja:
                    <strong>Rp @{{ subtotal.toLocaleString() }}</strong>
                </p>
        
                <div class="mb-3">
                    <label>Biaya Tambahan / Denda</label>
                    <input type="number"
                        class="form-control"
                        v-model.number="fee"
                        min="0">
                </div>
        
                <p class="fw-bold">
                    Keseluruhan Harga:
                    <span class="text-success">
                        Rp @{{ total.toLocaleString() }}
                    </span>
                </p>
        
                <div class="mb-3">
                    <label>Uang Pembeli</label>
                    <input type="number"
                        class="form-control"
                        v-model.number="cash"
                        min="0">
        
                    <p class="mt-2">
                        Kembalian:
                        <strong :class="cash < total ? 'text-danger' : 'text-success'">
                            Rp @{{ change.toLocaleString() }}
                        </strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success"
                        :disabled="cash < total"
                        @click="confirmCharge">
                    OK
                </button>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>



{{-- <script>
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

    setTimeout(() => {
        alert.classList.remove('show');
        alert.classList.add('hide');
        setTimeout(() => alert.remove(), 300);
    }, 3000);
}
</script> --}}

<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            cart: {},
            cash: 0,
            fee: 0
        }
    },
    computed: {
        subtotal() {
            return Object.values(this.cart)
                .reduce((sum, item) => sum + item.qty * item.price, 0);
        },
        total() {
            return this.subtotal + this.fee;
        },
        isEmpty() {
            return Object.keys(this.cart).length === 0;
        },
        change() {
            return this.cash >= this.total
                ? this.cash - this.total
                : 0;
        }
    },
    methods: {
        addItem(menu) {
            if (this.cart[menu.id]) {
                this.cart[menu.id].qty++;
            } else {
                this.cart[menu.id] = {
                    name: menu.name,
                    price: menu.price,
                    qty: 1
                };
            }
        },
        removeItem(id) {
            delete this.cart[id];
        },
        openCharge() {
            this.cash = 0;
            this.fee = 0;

            new bootstrap.Modal(
                document.getElementById('chargeModal')
            ).show();
        },
        confirmCharge() {
            if (this.cash < this.total) {
                this.showAlert('Uang pembeli tidak cukup', 'danger');
                return;
            }

            this.showAlert('Transaksi berhasil', 'success');

            this.cart = {};
            this.cash = 0;
            this.fee  = 0;

            bootstrap.Modal.getInstance(
                document.getElementById('chargeModal')
            ).hide();
        },
        printReceipt() {
            window.print();
        },
        showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');

            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show shadow`;
            alert.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            alertContainer.appendChild(alert);

            setTimeout(() => {
                alert.classList.remove('show');
                alert.classList.add('hide');
                setTimeout(() => alert.remove(), 300);
            }, 3000);
        }
    }
}).mount('#app');
</script>

<style>
.menu-card {
    transition: all 0.2s ease;
}
.menu-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
</style>
@endsection