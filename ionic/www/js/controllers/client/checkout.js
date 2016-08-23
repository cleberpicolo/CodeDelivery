angular.module('starter.controllers')
    .controller('ClientCheckoutCtrl', [
        '$scope', '$ionicLoading', '$ionicPopup', '$state', '$cart', 'Order', 'Cupom', '$cordovaBarcodeScanner',
        function ($scope, $ionicLoading, $ionicPopup, $state, $cart, Order, Cupom, $cordovaBarcodeScanner) {
            var cart = $cart.get();
            $scope.cupom = cart.cupom;
            $scope.items = cart.items;
            $scope.total = $cart.getTotalFinal();
            $scope.showDelete = false;

            $scope.removeItem = function (i) {
                console.log(i);
                $cart.removeItem(i);
                $scope.items.splice(i, 1);
                $scope.total = $cart.getTotalFinal();
            };

            $scope.openProductDetail = function (i) {
                $state.go('client.checkout_item_detail', {index: i});
            };

            $scope.openListProducts = function () {
                $state.go('client.view_products');
            };

            $scope.save = function () {
                var o = {items: angular.copy($scope.items)};
                angular.forEach(o.items, function (item) {
                    item.product_id = item.id;
                });

                $ionicLoading.show({
                    template: 'Carregando...'
                });

                if($scope.cupom.value){
                    o.cupom_code = $scope.cupom.code;
                }

                Order.save({id: null}, o, function (data) {
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
            };

            $scope.readBarCode = function () {
                $cordovaBarcodeScanner
                    .scan()
                    .then(function(barcodeData) {
                        console.log(barcodeData);
                        getValueCupom(barcodeData.text);
                    }, function(error) {
                        $ionicPopup.alert({
                            title: 'Error',
                            template: 'Não foi possível ler o código de barras, tente novamente.'
                        });
                    });
            };

            $scope.removeCupom = function () {
                $cart.removeCupom();
                $scope.cupom = $cart.get().cupom;
                $scope.total = $cart.getTotalFinal();
            };

            function getValueCupom(code) {
                $ionicLoading.show({
                    template: 'Carregando...'
                });
                Cupom.get({code: code}, function (data) {
                    $cart.setCupom(data.data.code, data.data.value);
                    $scope.cupom = $cart.get().cupom;
                    $scope.total = $cart.getTotalFinal();
                    $ionicLoading.hide();
                }, function (error) {
                    $ionicLoading.hide();
                    $ionicPopup.alert({
                        title: 'Error',
                        template: 'Cupom inválido!'
                    });
                    console.log(error);
                });
            }

        }]);