angular.module('starter.controllers')
    .controller('ClientOrderCtrl', [
        '$scope', '$ionicLoading', '$stateParams', 'ClientOrder',
        function ($scope, $ionicLoading, $stateParams, ClientOrder) {

            $scope.order = {};
            $ionicLoading.show({
                template: "Carregando..."
            });

            ClientOrder.get({id: $stateParams.id, include: "items,cupom"}, function (data) {
                $scope.order = data.data;
                $ionicLoading.hide();
            }, function (error) {
                $ionicLoading.hide();
            });

        }]);