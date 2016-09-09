angular.module('starter.controllers')
    .controller('DeliverymanMenuCtrl', [
        '$scope', '$ionicLoading', '$state', 'UserData',
        function ($scope, $ionicLoading, $state, UserData) {
            $scope.user = UserData.get();
        }]);