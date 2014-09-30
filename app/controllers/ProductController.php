<?php 


class ProductController extends BaseController{


	public function home(){
		$defaultQuery = 'halloween+costume';
		$fd = (Input::get('fd')!= '') ? Input::get('fd') : NULL;

		$all = Toolbox::getresultswithfilter($defaultQuery, 196, $fd);
		// $filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
		

		if($all){
			$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
			$products = $all->xpath('//product-results-module/product-results/product');
			return View::make('front')->with('products', $products)->with('query',$defaultQuery)->with('hasResult', true)->with('popularProducts', $popularProducts);
		}else{
			return View::make('front')->with('hasResult', false)->with('query', $defaultQuery);
		}
	} 

	public function data(){
		$all = Toolbox::getresultswithfilter('toys',10);
		//$filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
		$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
		$products = $all->xpath('//product-results-module/product-results/product');
		Toolbox::debug($products);
		// return $products;
		
	}

	public function debug(){
		$products = Toolbox::getSearchResults('ipad',15);
		
	}

	public function query(){
		$query = Input::get('query');
		$fd = (Input::get('fd')!= '') ? Input::get('fd') : NULL;

		$all = Toolbox::getresultswithfilter($query, 196, $fd);
		// $filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');

		if($all){
			$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
			$products = $all->xpath('//product-results-module/product-results/product');
			return View::make('front')->with('products', $products)->with('query',$query)->with('hasResult', true)->with('popularProducts', $popularProducts);
		}else{
			return View::make('front')->with('hasResult', false)->with('query', $query);
		}

		// Toolbox::debug($all);
	}

}