angular.module('starter.services')
    .service('$cart', ['$localStorage', function ($localStorage) {

        var key = 'cart';

        if(!$localStorage.getObject(key)){
            initCart();
        }

        this.clear = function () {
            initCart();
        };

        this.get = function () {
            return $localStorage.getObject(key);
        };

        this.getItem = function (i) {
            return this.get().items[i];
        };

        this.addItem = function (item) {
            var cart = this.get(), itemAux, exists = false;
            for(var i in cart.items){
                itemAux = cart.items[i];
                if(itemAux.id == item.id){
                    itemAux.qtd = item.qtd + itemAux.qtd;
                    itemAux.subtotal = calculateSubTotal(itemAux);
                    exists = true;
                    break;
                }
            }
            if(!exists){
                item.subtotal = calculateSubTotal(item);
                cart.items.push(item);
            }
            cart.total = calculateTotal(cart.items);
            $localStorage.setObject(key, cart);
        };

        this.removeItem = function (i) {
            var cart = this.get();
            cart.items.splice(i, 1);
            cart.total = calculateTotal(cart.items);
            $localStorage.setObject(key, cart);
        };

        this.updateQtd = function (i, qtd) {
            var cart = this.get(),
                itemAux = cart.items[i];
            itemAux.qtd = qtd;
            itemAux.subtotal = calculateSubTotal(itemAux);
            cart.total = calculateTotal(cart.items);
            cart.items[i] = itemAux;
            $localStorage.setObject(key, cart);
        };

        function calculateSubTotal(item) {
            return item.price * item.qtd;
        }

        function calculateTotal(items) {
            var sum = 0;
            angular.forEach(items, function (item) {
                sum += item.subtotal;
            });
            return sum;
        }

        function initCart() {
            $localStorage.setObject(key, {
                items: [],
                total: 0
            });
        }

    }]);