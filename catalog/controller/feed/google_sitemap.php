<?php
class ControllerFeedGoogleSitemap extends Controller {
	public function index() {
		if ($this->config->get('google_sitemap_status')) {
			$output  = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

			$this->load->model('catalog/product');
			$this->load->model('tool/image');

			$this->load->model("pavblog/category");
			$pb_categories=$this->model_pavblog_category->getInfo();

			foreach ($pb_categories as $pb_category) 
			{
				$output .= '<url>';
				$output .= '<loc>' . htmlentities($this->url->link('pavblog/category', 'id=' . $pb_category['category_id'],'SSL')) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.7</priority>';
				$output .= '</url>';
			}

			$this->load->model("pavblog/blog");
			$pb_blogs=$this->model_pavblog_blog->getAllBlogs(array("sort"=>"b.position"));

			foreach ($pb_blogs as $pb_blog) 
			{
				$output .= '<url>';
				$output .= '<loc>' . htmlentities($this->url->link('pavblog/blog', 'id=' . $pb_blog['blog_id'],'SSL')) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.7</priority>';
				$output .= '</url>';
			}  

			$products = $this->model_catalog_product->getProducts();

			foreach ($products as $product) { 
				if ($product['image']) { 
					$output .= '<url>';
					$output .= '<loc>' . htmlentities ($this->url->link('product/product', 'product_id=' . $product['product_id'],'SSL')) . '</loc>';
					$output .= '<changefreq>weekly</changefreq>';
					$output .= '<priority>1.0</priority>';
					// $output .= '<image:image>';
					// $output .= '<image:loc>' . htmlentities($this->model_tool_image->orig($product['image'])) . '</image:loc>';
					// $output .= '<image:loc>' . $this->model_tool_image->resize($product['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')) . '</image:loc>';
					// $output .= '<image:caption>' . $product['name'] . '</image:caption>';
					// $output .= '<image:title>' . $product['name'] . '</image:title>';
					// $output .= '</image:image>';
					$output .= '</url>';
				}
			} 

			$this->load->model('catalog/category');

			$output .= $this->getCategories(0);

			// $this->load->model('catalog/manufacturer');

			// $manufacturers = $this->model_catalog_manufacturer->getManufacturers();

			// foreach ($manufacturers as $manufacturer) {
			// 	$output .= '<url>';
			// 	$output .= '<loc>' . htmlentities($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id'],'SSL')) . '</loc>';
			// 	$output .= '<changefreq>weekly</changefreq>';
			// 	$output .= '<priority>0.7</priority>';
			// 	$output .= '</url>';

			// 	$products = $this->model_catalog_product->getProducts(array('filter_manufacturer_id' => $manufacturer['manufacturer_id']));

			// 	foreach ($products as $product) {
			// 		$output .= '<url>';
			// 		$output .= '<loc>' . htmlentities($this->url->link('product/product', 'manufacturer_id=' . $manufacturer['manufacturer_id'] . '&product_id=' . $product['product_id'],'SSL')) . '</loc>';
			// 		$output .= '<changefreq>weekly</changefreq>';
			// 		$output .= '<priority>1.0</priority>';
			// 		$output .= '</url>';
			// 	}
			// }

			$this->load->model('catalog/information');

			$informations = $this->model_catalog_information->getInformations();

			foreach ($informations as $information) {
				if (!in_array( $information['information_id'], array(25,13,15,19)))
				{
					$output .= '<url>';
					$output .= '<loc>' . htmlentities($this->url->link('information/information', 'information_id=' . $information['information_id'],'SSL')) . '</loc>';
					$output .= '<changefreq>weekly</changefreq>';
					$output .= '<priority>0.5</priority>';
					$output .= '</url>';
				}
			}

			$output .= '</urlset>';

			$this->response->addHeader('Content-Type: application/xml');
			$this->response->setOutput($output);
		}
	}

	protected function getCategories($parent_id, $current_path = '') {
		$output = '';

		$results = $this->model_catalog_category->getCategories($parent_id);

		foreach ($results as $result) {
			if (!$current_path) {
				$new_path = $result['category_id'];
			} else {
				$new_path = $current_path . '_' . $result['category_id'];
			}

			$output .= '<url>';
			$output .= '<loc>' . htmlentities($this->url->link('product/category', 'path=' . $new_path,'SSL')) . '</loc>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>0.7</priority>';
			$output .= '</url>';

			$products = $this->model_catalog_product->getProducts(array('filter_category_id' => $result['category_id']));

			foreach ($products as $product) {
				$output .= '<url>';
				$output .= '<loc>' . htmlentities($this->url->link('product/product', 'path=' . $new_path . '&product_id=' . $product['product_id'],'SSL')) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>1.0</priority>';
				$output .= '</url>';
			}

			$output .= $this->getCategories($result['category_id'], $new_path);
		}

		return $output;
	}
}
