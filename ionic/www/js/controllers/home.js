angular.module('starter.controllers')
    .controller('HomeCtrl', [
        '$scope', '$http', '$cookies', '$state', 'Auth',
        function ($scope, $http, $cookies, $state, Auth) {

        Auth.get({}, function (data) {
            var userLogged = data.data;
            console.log(userLogged);
            if(userLogged.role == 'client') {
                $state.go('client.view_products');
            }
        }, function (error) {
            $state.go('login');
        });

    }]);