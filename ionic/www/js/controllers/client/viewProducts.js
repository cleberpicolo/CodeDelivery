angular.module('starter.controllers')
    .controller('ClientViewProductsCtrl', [
        '$scope', '$ionicLoading', '$state', 'Product', '$cart',
        function ($scope, $ionicLoading, $state, Product, $cart) {

            $scope.products = [];
            $ionicLoading.show({
                template: 'Carregando...'
            });
            Product.query({}, function (data) {
                console.log(data);
                $scope.products = data.data;
                $ionicLoading.hide();
            }, function (error) {
                $ionicLoading.hide();
            });

            $scope.addItem = function (item) {
                item.qtd = 1;
                $cart.addItem(item);
                $state.go('client.checkout');
            };

        }]);