<?php 


class ProductController extends BaseController{


	public function home(){
		$defaultQuery = 'halloween+costume';
		$fd = (Input::get('mid')!= '') ? Input::get('mid') : '';

		$all = Toolbox::getresultswithfilter($defaultQuery,196, $fd);	
			
		if($all){
			$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
			$products = $all->xpath('//product-results-module/product-results/product');
			$merchant = $all->xpath('//popular-merchants-module/popular-merchants/merchant');
			return View::make('front')->with('products', $products)
			->with('query',$defaultQuery)
			->with('hasResult', true)
			->with('popularProducts', $popularProducts)
			->with('merchants',$merchant);
		}else{
			return View::make('front')->with('hasResult', false)->with('query', $defaultQuery);
		}
	} 





	public function data(){
		$all = Toolbox::getresultswithfilter('halloween+costume', 10);
		// $filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
		$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
		$products = $all->xpath('//product-results-module/product-results/product');
		$merchant = $all->xpath('//popular-merchants-module/popular-merchants/merchant');
		Toolbox::debug($merchant);
		// return $products;
		
	}

	public function debug(){
		$products = Toolbox::getSearchResults('ipad',15);
		
	}

	public function query(){
		$query = Input::get('query');
		$fd = (Input::get('fd')!= '') ? Input::get('fd') : NULL;

		$all = Toolbox::getresultswithfilter($query, 196, $fd);
		if($all){
			$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
			$products = $all->xpath('//product-results-module/product-results/product');
			$merchant = $all->xpath('//popular-merchants-module/popular-merchants/merchant');
			return View::make('front')->with('products', $products)
			->with('query',$query)
			->with('hasResult', true)
			->with('popularProducts', $popularProducts)
			->with('merchants',$merchant);
		}else{
			return View::make('front')->with('hasResult', false)->with('query', $query);
		}
	}

}


// To dos
// 1. those with discounts, can we place original price with strikethrough and the new price? - done
// 2. if we come up with popular products or popular merchants, can we place it there
// 3. Add merchants from merchant module