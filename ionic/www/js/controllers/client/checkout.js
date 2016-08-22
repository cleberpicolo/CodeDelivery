angular.module('starter.controllers')
    .controller('ClientCheckoutCtrl', [
        '$scope', '$ionicLoading', '$ionicPopup', '$state', '$cart', 'Order',
        function ($scope, $ionicLoading, $ionicPopup, $state, $cart, Order) {
            var cart = $cart.get();
            $scope.items = cart.items;
            $scope.total = cart.total;
            $scope.showDelete = false;

            $scope.removeItem = function (i) {
                console.log(i);
                $cart.removeItem(i);
                $scope.items.splice(i, 1);
                $scope.total = $cart.get().total;
            };

            $scope.openProductDetail = function (i) {
                $state.go('client.checkout_item_detail', {index: i});
            };

            $scope.openListProducts = function () {
                $state.go('client.view_products');
            };

            $scope.save = function () {
                var items = angular.copy($scope.items);
                angular.forEach(items, function (item) {
                    item.product_id = item.id;
                });

                $ionicLoading.show({
                    template: 'Carregando...'
                });

                Order.save({id: null}, {items: items}, function (data) {
                    $ionicLoading.hide();
                    $state.go('client.checkout_successful');
                }, function (error) {
                    $ionicPopup.alert({
                        title: 'Error',
                        template: 'Pedido não realizado, tente novamente'
                    });
                    console.log(error);
                    $ionicLoading.hide();
                });
            }

        }]);