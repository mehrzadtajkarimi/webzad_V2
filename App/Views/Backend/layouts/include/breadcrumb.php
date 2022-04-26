<div class="col-sm-6">
  <h1>*</h1>
</div>
<div class="col-sm-6">
  <ol class="breadcrumb float-sm-left">
    <li class="breadcrumb-item"><a href="<?= base_url() ?>admin">داشبورد</a></li>
	<?php
	if (isset($breadcrumb))
	{
		$counter=0;
		foreach ($breadcrumb as $linkAnchor=>$linkHref)
		{
			$counter++;
			if ($linkHref!="#")
			{
				$linkStart='<a href="'.base_url().'admin/'.$linkHref.'">';
				$linkEnd='</a>';
			}
			else $linkStart=$linkEnd='';
			
			if ($counter==count($breadcrumb))
				$activeStr=" active";
			else
				$activeStr="";
			
			echo '<li class="breadcrumb-item'.$activeStr.'">'.$linkStart.$linkAnchor.$linkEnd.'</li>';
		}
	}
	?>
  </ol>
</div>