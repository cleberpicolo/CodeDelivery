angular.module('starter.controllers', [])
    .controller('LoginCtrl', [
        '$scope', 'OAuth', '$ionicPopup', '$ionicLoading', '$state',
        function ($scope, OAuth, $ionicPopup, $ionicLoading, $state) {

        $scope.user = {
            username: '',
            password: ''
        };

        $scope.login = function () {
            $ionicLoading.show({
                template: 'Loading ...'
            });
            OAuth.getAccessToken($scope.user)
                .then(function (data) {
                    $ionicLoading.hide();
                    $state.go('home');
                },function (responseError) {
                    $ionicLoading.hide();
                    $ionicPopup.alert({
                        title: 'Acesso Negado',
                        template: 'Login e/ou senha inválidos'
                    });
                    console.log(responseError);
                });
        }
    }]);