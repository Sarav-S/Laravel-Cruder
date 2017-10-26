<?php

namespace Sarav\Http\Traits;

trait CreateProviders
{
	public function processProviders()
	{
		$content = str_replace(
			'DummyName',
			$this->qualifiedName(),
			$this->file->get($this->stubsPath().'serviceprovider.stub')
		);

		$this->checkAndCreate($this->basePath.'Providers');

		$this->file->put($this->basePath.'Providers/'.$this->qualifiedName().'ServiceProvider.php', $content);

		$content = str_replace(
			'DummyName',
			$this->qualifiedName(),
			$this->file->get($this->stubsPath().'routeserviceprovider.stub')
		);

		$this->file->put($this->basePath.'Providers/RouteServiceProvider.php', $content);
	}
}