<?php 


class DecidoController extends BaseController{


	public function home(){
		$defaultQuery = 'halloween costume';

		$all = Toolbox::getresultswithfilterDecido($defaultQuery, 196);
		// $filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
		if($all){
			$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
			$products = $all->xpath('//product-results-module/product-results/product');
			return View::make('decido.front')->with('products', $products)->with('popularProducts', $popularProducts)->with('hasResult', true);
		}else{
			return View::make('decido.front')->with('hasResult', false)->with('query', $defaultQuery);
		}
	} 

	public function data(){
		$all = Toolbox::getresultswithfilterDecido('ipad',1);
		$filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
		$products = $all->xpath('//product-results-module/product-results/product');
		Toolbox::debug($all);
		// return $products;
		
	}

	public function debug(){
		$products = Toolbox::getSearchResults('ipad',15);
		
	}

	public function query(){
		$query = Input::get('query');

		$all = Toolbox::getresultswithfilterDecido($query, 196);

		if($all){
			$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
			$products = $all->xpath('//product-results-module/product-results/product');
			return View::make('decido.front')->with('products', $products)->with('popularProducts', $popularProducts)->with('hasResult', true);
		}else{
			return View::make('decido.front')->with('hasResult', false)->with('query', $query);
		}

		// Toolbox::debug($all);
	}

}