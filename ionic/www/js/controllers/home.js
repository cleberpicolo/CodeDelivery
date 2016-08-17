angular.module('starter.controllers')
    .controller('HomeCtrl', ['$scope', '$http', '$cookies', function ($scope, $http, $cookies) {

        console.log("Home controller...");

        $scope.name = '';

        $http.defaults.headers.common.Authorization = 'Bearer '+$cookies.getObject('token').access_token;
        $http.get('http://localhost:8000/api/authenticated')
            .then(function (data) {
                var userLogged = data.data.data;
                $scope.name = userLogged.name;
            },function (responseError) {
                console.log(responseError);
            })

    }]);