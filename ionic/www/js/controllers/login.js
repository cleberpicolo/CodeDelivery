angular.module('starter.controllers')
    .controller('LoginCtrl', [
        '$scope', 'OAuth', 'OAuthToken', '$ionicPopup', '$ionicLoading', '$state', '$localStorage', 'User', 'UserData',
        function ($scope, OAuth, OAuthToken, $ionicPopup, $ionicLoading, $state, $localStorage, User, UserData) {

        $scope.user = {
            username: '',
            password: ''
        };

        $scope.login = function () {
            $ionicLoading.show({
                template: 'Loading ...'
            });

            var promise = OAuth.getAccessToken($scope.user);

            promise
                .then(function (data) {
                    return User.authenticated({include: 'client'}).$promise;
                })
                .then(function (data) {
                    UserData.set(data.data);
                    $ionicLoading.hide();
                    $state.go('client.checkout');
                }, function (error) {
                    UserData.set(null);
                    OAuthToken.removeToken();
                    $ionicLoading.hide();
                    $ionicPopup.alert({
                        title: 'Acesso Negado',
                        template: 'Login e/ou senha inválidos'
                    });
                    console.log(error);
                });
        }
    }]);