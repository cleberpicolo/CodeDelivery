angular.module('starter.controllers')
    .controller('ClientViewOrdersCtrl', [
        '$scope', '$ionicLoading', '$state', 'Order',
        function ($scope, $ionicLoading, $state, Order) {

            $scope.orders = [];
            $ionicLoading.show({
                template: 'Carregando...'
            });
            Order.query({include: "items"}, function (data) {
                console.log(data);
                $scope.orders = data.data;

                angular.forEach($scope.orders, function (order) {
                    switch (order.status){
                        case 0: order.status = 'Pendente'; break;
                        case 1: order.status = 'Processando'; break;
                        case 2: order.status = 'Entregue'; break;
                        case 3: order.status = 'Cancelado'; break;
                    }
                    var dt = new Date(order.created_at.date);
                    order.created_at.date = dt;
                    var items = order.items.data.length;
                    if(items > 1){
                        order.orderItems = items + " Itens";
                    }else{
                        order.orderItems = items + " Item";
                    }
                });

                $ionicLoading.hide();
            }, function (error) {
                $ionicLoading.hide();
            });

        }]);