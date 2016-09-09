angular.module('starter.controllers')
    .controller('DeliverymanViewOrdersCtrl', [
        '$scope', '$ionicLoading', '$state', 'DeliverymanOrder',
        function ($scope, $ionicLoading, $state, DeliverymanOrder) {

            $scope.orders = [];
            $ionicLoading.show({
                template: 'Carregando...'
            });

            $scope.doRefresh = function () {
                getOrders().then(function (data) {
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

                    $scope.$broadcast('scroll.refreshComplete');
                }, function (error) {
                    $scope.$broadcast('scroll.refreshComplete');
                })
            };

            $scope.openOrderDetail = function (order) {
                $state.go("deliveryman.order", {id: order.id});
            };

            function getOrders() {
                return DeliverymanOrder.query({
                    include: "items",
                    orderBy: "created_at",
                    sortedBy: "desc"
                }).$promise;
            }

            getOrders().then(function (data) {
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
                }
            );

        }]);