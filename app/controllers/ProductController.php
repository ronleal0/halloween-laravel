<?php 


class ProductController extends BaseController{


	public function home(){
		$gclid = (Input::get('gclid')) ? Input::get('gclid') : false;
		$defaultQuery = 'halloween';
		$fd = (Input::get('mid')!= '') ? Input::get('mid') : '';
		$all = Toolbox::getresultswithfilter($defaultQuery, 100, $fd);	
		

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
			->with('isQueryPage', false)
			->with('gclid', $gclid);
		}else{
			return View::make('front')->with('hasResult', false)->with('query', $defaultQuery);
		}
	} 
	public function query(){
		
		$query = Input::get('query');
		$gclid = (Input::get('gclid')) ? Input::get('gclid') : false;
		$fd = (Input::get('fd')!= '') ? Input::get('fd') : NULL;

		$all = Toolbox::getresultswithfilter($query, 100, $fd);
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
			->with('isQueryPage', true)
			->with('gclid', $gclid);
		}else{
			return View::make('front')->with('hasResult', false)->with('query', $query);
		}
	}

	public function jsonHome(){
		$gclid = (Input::get('gclid')) ? Input::get('gclid') : false;
		$defaultQuery = 'bag';
		$fd = (Input::get('mid')!= '') ? Input::get('mid') : '';
		$results = Toolbox::getResultingJSON($defaultQuery, 100, $fd);	

		$filter = $results['resultFilterModule']['resultFilter'][0]['filterDimension'][0]['dimensionClass'];
		$products = $results['productResultsModule']['productResults']['product'];
		$popular = $results['popularProductsModule']['popularProducts']['product'];
	
		/*return View::make('json/testing')
		->with('products', $products)
		->with('query',$defaultQuery)
		->with('popularProducts',$popular)
		->with('isQueryPage', false)
		->with('gclid', $gclid)
		->with('hasResult',true);*/

		return $products;
	}
}



