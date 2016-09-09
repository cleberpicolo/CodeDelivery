angular.module('starter.controllers')
    .controller('ClientMenuCtrl', [
        '$scope', '$ionicLoading', '$state', 'UserData',
        function ($scope, $ionicLoading, $state, UserData) {
            $scope.user = UserData.get();
        }]);