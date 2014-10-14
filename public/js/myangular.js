var App = angular.module('myApp',[]);


App.controller('appController',function($scope){
	$scope.products = products;
});


App.controller('sideController', function($scope){
	$scope.categories = Categories;
	$scope.merchants = Merchants;
});


var Categories = [
	{
		"name" : "Halloween Costume Accessories",
		"parameter" : "costumeAccessories"
	},
	{
		"name" : "Halloween Costumes For Adults",
		"parameter" : "costumesForAdults"
	},
	{
		"name" : "Halloween Costumes For Kids",
		"parameter" : "costumesForKids"
	},
	{
		"name" : "Halloween Costumes For Pets",
		"parameter" : "costumesForPets"
	},
	{
		"name" : "Costume For Kids",
		"parameter" : "costumeForKids"
	},
	{
		"name" : "Halloween Decorations",
		"parameter" : "decorations"
	},
]

var Merchants = [
	{
		"name" : "Kmart",
		"parameter" : "kmart"
	},
	{
		"name" : "Sears",
		"parameter" : "sears"
	},
	{
		"name" : "SpirtHalloween",
		"parameter" : "spirithalloween"
	},
	{
		"name" : "Wholesale Halloween Costumes",
		"parameter" : "wholesaleHalloweenCostumes"
	}
	
]