angular.module('starter.controllers')
    .controller('ClientCheckoutDetailCtrl', [
        '$scope', '$ionicLoading', '$state', '$stateParams', '$cart',
        function ($scope, $ionicLoading, $state, $stateParams, $cart) {

            var index = $stateParams.index;
            $scope.product = $cart.getItem(index);
            $scope.updateQtd = function () {
                $cart.updateQtd(index, $scope.product.qtd);
                $state.go('client.checkout');
            };

        }]);