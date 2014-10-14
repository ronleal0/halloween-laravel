<?php 


class ProductController extends BaseController{


	public function home(){
		$defaultQuery = 'halloween';
		$fd = (Input::get('mid')!= '') ? Input::get('mid') : '';
		$all = Toolbox::getresultswithfilter($defaultQuery, 196, $fd);	
		

		if($all){
			$filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
			$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
			$products = $all->xpath('//product-results-module/product-results/product');
			$merchant = $all->xpath('//popular-merchants-module/popular-merchants/merchant');
			return View::make('front')->with('products', $products)
			->with('query',$defaultQuery)
			->with('hasResult', true)
			->with('popularProducts', $popularProducts)
			->with('filters', $filters)
			->with('merchants',$merchant)
			->with('isQueryPage', false);
		}else{
			return View::make('front')->with('hasResult', false)->with('query', $defaultQuery);
		}
	} 
	public function query(){
		$query = Input::get('query');
		$fd = (Input::get('fd')!= '') ? Input::get('fd') : NULL;

		$all = Toolbox::getresultswithfilter($query, 196, $fd);
		if($all){
			$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
			$filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
			$products = $all->xpath('//product-results-module/product-results/product');
			$merchant = $all->xpath('//popular-merchants-module/popular-merchants/merchant');
			return View::make('front')->with('products', $products)
			->with('query',$query)
			->with('hasResult', true)
			->with('popularProducts', $popularProducts)
			->with('filters', $filters)
			->with('merchants',$merchant)
			->with('isQueryPage', true);
		}else{
			return View::make('front')->with('hasResult', false)->with('query', $query);
		}
	}

	public function data(){
		$query = 'halloween';
		$fd = (Input::get('fd')!= '') ? Input::get('fd') : NULL;

		$all = Toolbox::getresultswithfilter($query, 196, $fd);
		$products = $all->xpath('//product-results-module');
		return $products;
		// Toolbox::debug($products);

		/*if($all){
			$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
			$filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
			$products = $all->xpath('//product-results-module/product-results/product');
			$merchant = $all->xpath('//popular-merchants-module/popular-merchants/merchant');
			return View::make('front')->with('products', $products)
			->with('query',$query)
			->with('hasResult', true)
			->with('popularProducts', $popularProducts)
			->with('filters', $filters)
			->with('merchants',$merchant)
			->with('isQueryPage', true);
		}else{
			return View::make('front')->with('hasResult', false)->with('query', $query);
		}*/
	}


}



