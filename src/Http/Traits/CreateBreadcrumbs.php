<?php 

namespace Sarav\Http\Traits;

trait CreateBreadcrumbs
{
	public function processBreadcrumbs()
	{
		$module = strtolower($this->pluralName());

		$index  = "admin.".$module.".index";
		$create = "admin.".$module.".create";
		$show   = "admin.".$module.".show";
		$edit   = "admin.".$module.".edit";

		$content = str_replace(
			['DummyIndex', 'DummyCreate', 'DummyShow', 'DummyEdit', 'DummyModule'],
			[$index, $create, $show, $edit, $this->qualifiedName()],
			$this->file->get($this->stubsPath().'links.stub')
		);

		$this->checkAndCreate($this->basePath.'breadcrumbs');

		$this->file->put($this->basePath.'breadcrumbs/links.php', $content);
	}
}