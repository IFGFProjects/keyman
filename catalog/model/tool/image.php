<?php
class ModelToolImage extends Model {
	public function resize($filename, $width, $height) {
		if (!is_file(DIR_IMAGE . $filename)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}

		if ($this->request->server['HTTPS']) {
			return $this->config->get('config_ssl') . 'image/' . $new_image;
		} else {
			return $this->config->get('config_url') . 'image/' . $new_image;
		}
	}

	public function orig($filename,$quality=50)
	{
			if (!is_file(DIR_IMAGE . $filename)) {
				return;
			}

			$extension = pathinfo($filename, PATHINFO_EXTENSION);

			$old_image = $filename;
			$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-original.' . $extension;

			if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) 
			{
				$path = '';

				$directories = explode('/', dirname(str_replace('../', '', $new_image)));

				foreach ($directories as $directory) {
					$path = $path . '/' . $directory;

					if (!is_dir(DIR_IMAGE . $path)) {
						@mkdir(DIR_IMAGE . $path, 0777);
					}
				}

				$image = new Image(DIR_IMAGE . $old_image);
				$image->save(DIR_IMAGE . $new_image,$quality);
			}

			if ($this->request->server['HTTPS']) {
				return $this->config->get('config_ssl') . 'image/' . $new_image;
			} else {
				return $this->config->get('config_url') . 'image/' . $new_image;
			}
	}

	public function property_recount_width($filename,$eq=1)
	{
		if ( (!is_file(DIR_IMAGE . $filename)) || ($eq==0) ) 
			{return;}
		list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $filename);
		return $width_orig*$eq;
	}

	public function property_recount_height($filename,$eq=1)
	{
		if ( (!is_file(DIR_IMAGE . $filename)) || ((float)$eq==0) ) 
			{return 0;}
		list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $filename);
		return $height_orig*$eq;
	}

	public function property_recount($filename,$eq=1)
	{
		if ( (!is_file(DIR_IMAGE . $filename)) || ($eq==0) ) 
			{return;}
		list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $filename);
		return array("width"=>$width_orig*$eq,"height"=>$height_orig*$eq);
	}
}
