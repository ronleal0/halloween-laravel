<?php 


class DecidoController extends BaseController{


	public function home(){
		$defaultQuery = 'halloween';
		$fd = (Input::get('mid')!= '') ? Input::get('mid') : '';
		$all = Toolbox::getresultswithfilterDecido($defaultQuery,196, $fd);	


		if($all){
			$filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
			$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
			$products = $all->xpath('//product-results-module/product-results/product');
			$merchant = $all->xpath('//popular-merchants-module/popular-merchants/merchant');
			return View::make('decido.front')->with('products', $products)
			->with('query',$defaultQuery)
			->with('hasResult', true)
			->with('popularProducts', $popularProducts)
			->with('filters', $filters)
			->with('merchants',$merchant)
			->with('isQueryPage', false);
		}else{
			return View::make('decido.front')->with('hasResult', false)->with('query', $defaultQuery);
		}

		return View::make('testing')->with('products',$products);
	} 
	public function query(){
		$query = Input::get('query');
		$fd = (Input::get('fd')!= '') ? Input::get('fd') : NULL;

		$all = Toolbox::getresultswithfilterDecido($query, 196, $fd);

		// echo $all->{'product-results-module'}->{'product-results'}['total'];
		if($all){
			if($all->{'product-results-module'}->{'product-results'}['total'] != 0){
				$popularProducts = $all->xpath('//popular-products-module/popular-products/product');
				$filters = $all->xpath('//result-filter-module/result-filter/filter-dimension');
				$products = $all->xpath('//product-results-module/product-results/product');
				$merchant = $all->xpath('//popular-merchants-module/popular-merchants/merchant');
				return View::make('decido.front')->with('products', $products)
				->with('query',$query)
				->with('hasResult', true)
				->with('popularProducts', $popularProducts)
				->with('filters', $filters)
				->with('merchants',$merchant)
				->with('isQueryPage', true);
			}else{
				return View::make('decido.front')
				->with('hasResult', false)
				->with('query', $query)
				->with('debugError', "xml is ok but there is no result for that keyword");
			}
			
		}else{
			return View::make('decido.front')
			->with('hasResult', false)
			->with('query', $query)
			->with('debugError', "xml is empty");
		}
	}



	public function data(){
		// $query = (Input::get('query'))? Input::get('query') : 'halloween';
		$query = 'bag';
		$fd = (Input::get('fd')!= '') ? Input::get('fd') : NULL;

		$all = Toolbox::getresultswithfilterDecido($query, 196, $fd);
		$products = $all->xpath('//product-results-module/product-results/product');

		return $products;
	}
}