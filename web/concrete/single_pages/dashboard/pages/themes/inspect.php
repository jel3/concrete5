<?
defined('C5_EXECUTE') or die("Access Denied.");
$ci = Loader::helper('concrete/interface');
?>
	<h1><span><?=t('Inspect Theme: ')?> <?=$pageTheme->getThemeName() ?></span></h1>
	<div class="ccm-dashboard-inner">
	

	
	<form method="post" id="ccm-inspect-form" action="<?=$this->url('/dashboard/pages/themes/inspect/', 'activate_files', $ptID)?>">
	
	<div style="margin:0px; padding:0px; width:100%; height:auto" >	
	<table border="0" cellspacing="1" cellpadding="0" class="grid-list" id="ccm-template-list">
	<tr>
		<td colspan="3" class="header"><?=t('Files in Theme:')?>  <?=$pageTheme->getThemeHandle() ?> </td>

	</tr>
	<tr>
		<td class="subheader"><?=t('File')?></td>
		<td class="subheader"><?=t('Type')?></td>
		<td class="subheader"><?=t('Action to Take')?></td>
	</tr>
	<?	
	$txt = Loader::helper('text');
	$pf = 0;
	if (count($files) == 0) { ?>
	<tr>
	<td colspan="3">
	<?=t('There are no templates in this file.')?>
	</td>
	</tr>
	<? }
	
	foreach ($files as $f) { ?>
		<tr>
			<td><?=$f->getFilename()?></td>
			<td><?
				switch($f->getType()) {
					case PageThemeFile::TFTYPE_VIEW:
						print t("Wrapper for static pages");
						break;
					case PageThemeFile::TFTYPE_DEFAULT:
						print t("Default template");
						break;
					case PageThemeFile::TFTYPE_SINGLE_PAGE:
						print t("Template for internal Concrete page.");
						break;
					case PageThemeFile::TFTYPE_PAGE_TYPE_NEW:
						print t("New template.");
						break;
					case PageThemeFile::TFTYPE_PAGE_TYPE_EXISTING:
						print t("Template for existing page type.");
						break;
				}
			?></td>
			<td><?
				switch($f->getType()) {
					case PageThemeFile::TFTYPE_VIEW:
						print '<span class="deem">'.t('None. This file will automatically be used.').'</span>';
						break;
					case PageThemeFile::TFTYPE_DEFAULT:
						print '<span class="deem">'.t('None. This file will automatically be used for pages without a template.').'</span>';
						break;
					case PageThemeFile::TFTYPE_SINGLE_PAGE:
						print '<span class="deem">'.t('None. This file will automatically be used by the <strong>%s</strong> page.',$txt->unhandle($f->getHandle()) ).'</span>';
						break;
					case PageThemeFile::TFTYPE_PAGE_TYPE_NEW:
						$pf++;
						print '<input type="checkbox" value="' . $f->getHandle() . '" name="pageTypes[]" checked /> ' . t('Create page type.');
						break;
					case PageThemeFile::TFTYPE_PAGE_TYPE_EXISTING:
						print '<span class="deem">'.t('None. This file will automatically be used by the <strong>%s</strong> page type.',$txt->unhandle($f->getHandle())  ).'</span>';
						break;
				}
			?></td>
		</tr>
		
		<? } ?>
	</table>
	</div>
	
	<Br/>
	
	
	<?
	$b1 = $ci->button(t('Return to Add Functionality'), $this->url('/dashboard/install'), 'left');
	$b2 = $ci->button(t('Return to Themes'), $this->url('/dashboard/pages/themes'), 'left');
	if ($pf > 0) { 
		$b3 = $ci->submit(t('Activate Files'), 'ccm-inspect-form'); ?>
		<?=$ci->buttons($b1, $b2, $b3); ?>
	<? } else { ?>
		<?=$ci->buttons($b1, $b2); ?>
	<? } ?>
	</form>
	
	<br/><br/>
	
	</div>
	
