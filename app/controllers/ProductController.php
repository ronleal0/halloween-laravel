<?php 


class ProductController extends BaseController{


	public function home(){
		$defaultQuery = 'ipad';

		$all = Toolbox::getresultswithfilter($defaultQuery, 196);
		$filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
		$products = $all->xpath('//product-results-module/product-results/product');
		return View::make('front')
		->with('filters',$filters)
		->with('products', $products);
	} 

	public function data(){
		$all = Toolbox::getresultswithfilter('ipad',1);
		$filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
		$products = $all->xpath('//product-results-module/product-results/product');
		Toolbox::debug($products);
		// return $products;
		
	}

	public function debug(){
		$products = Toolbox::getSearchResults('ipad',15);
		
	}

	public function query(){
		$query = Input::get('query');

		$all = Toolbox::getresultswithfilter($query, 196);

		if($all){
			$products = $all->xpath('//product-results-module/product-results/product');
			return View::make('front')->with('products', $products)->with('query',$query)->with('hasResult', true);
		}else{
			return View::make('front')->with('hasResult', false)->with('query', $query);
		}

		// Toolbox::debug($all);
	}

}