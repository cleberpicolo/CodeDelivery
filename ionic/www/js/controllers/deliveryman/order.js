angular.module('starter.controllers')
    .controller('DeliverymanOrderCtrl', [
        '$scope', '$ionicLoading', '$stateParams', 'DeliverymanOrder',
        function ($scope, $ionicLoading, $stateParams, DeliverymanOrder) {

            $scope.order = {};
            $ionicLoading.show({
                template: "Carregando..."
            });

            DeliverymanOrder.get({id: $stateParams.id, include: "items,cupom"}, function (data) {
                $scope.order = data.data;
                $ionicLoading.hide();
            }, function (error) {
                $ionicLoading.hide();
            });

        }]);