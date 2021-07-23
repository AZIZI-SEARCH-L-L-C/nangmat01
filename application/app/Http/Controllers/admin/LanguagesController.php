<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use Config, Input, File, Session, Lang;

class LanguagesController extends Controller
{
    
	public function getAll(){
		$languages = Config::get('laravellocalization');
		
		$data1 = $this->CommonData();
		$data2 = [
		    'languages' => $languages,
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.allLanguages', $data);
	}
	
	public function postAll (){
		$errors = false;
		
		if(Input::has('submitDefaultLang')){
			$input = Input::only('defaultLanguage');
			$content = File::get(base_path('config'. DIRECTORY_SEPARATOR .'app.php'));
			
			$content = preg_replace("/('locale' => ).*?(.+?)\\n/msi", '${1}"'.$input['defaultLanguage']."\",\n", $content);
			
			File::put(base_path('config'. DIRECTORY_SEPARATOR .'app.php'), $content);
		}
		
		// add new language
		if(Input::has('submitAddLang')){
			
			$input = Input::only('newLanguage');
			$content = File::get(base_path('config'. DIRECTORY_SEPARATOR .'laravellocalization.php'));
			$content = str_replace("//'".$input['newLanguage']."'", "'".$input['newLanguage']."'", $content);
			$content = str_replace("// '".$input['newLanguage']."'", "'".$input['newLanguage']."'", $content);
			File::put(base_path('config'. DIRECTORY_SEPARATOR .'laravellocalization.php'), $content);
			
			// copy directory
			$defLocale = Config::get('app.locale');
			$path = base_path('resources'. DIRECTORY_SEPARATOR .'lang');
			$newPath = $path . DIRECTORY_SEPARATOR . $input['newLanguage'];
			if(!File::exists($newPath)){
				$defPath = $path . DIRECTORY_SEPARATOR . $defLocale;
				$this->copy_directory($defPath, $newPath);
			}
			
		}
		
		if(Input::has('submitDeleteLang')){
			$input = Input::only('LangCode');
			
			if($input['LangCode'] == Config::get('app.locale')){
				Session::flash('messageType', 'error');
			    Session::flash('message', 'You can\'t deactivate the default language, Please change your default language and then deactivate this.');
				return redirect()->action('admin\LanguagesController@getAll');
			}
			
			$content = File::get(base_path('config'. DIRECTORY_SEPARATOR .'laravellocalization.php'));
			
			$content = str_replace("'".$input['LangCode']."'", "// '".$input['LangCode']."'", $content);
			
			File::put(base_path('config'. DIRECTORY_SEPARATOR .'laravellocalization.php'), $content);
		}
		
		if(Input::has('submitLangSettings')){
			
			$LangHeader = "false";
			$LangURL    = "false";
			
			if(Input::has('langHeader')) $LangHeader = "true"; 
			if(Input::has('langURL'))    $LangURL = "true"; 
			
			$content = File::get(base_path('config'. DIRECTORY_SEPARATOR .'laravellocalization.php'));
			
			$languages = Config::get('laravellocalization');
			
			$content = str_replace("'useAcceptLanguageHeader' => true,", "'useAcceptLanguageHeader' => ".$LangHeader.", ", $content);
			$content = str_replace("'useAcceptLanguageHeader' => false,", "'useAcceptLanguageHeader' => ".$LangHeader.", ", $content);
			$content = str_replace("'hideDefaultLocaleInURL' => true,", "'hideDefaultLocaleInURL' => ".$LangURL.", ", $content);
			$content = str_replace("'hideDefaultLocaleInURL' => false,", "'hideDefaultLocaleInURL' => ".$LangURL.", ", $content);
			
			
			File::put(base_path('config'. DIRECTORY_SEPARATOR .'laravellocalization.php'), $content);
		}
		
		if(!$errors){
			Session::flash('messageType', 'success');
			Session::flash('message', 'All changes have been applied.');
		}
		return redirect()->action('admin\LanguagesController@getAll');
		
	}
	
	public function getEditPhrases($code, $file){
		
		Lang::setLocale($code);
		$phrases = Lang::get($file);
		if(!is_array($phrases)){
			Session::flash('messageType', 'error');
			Session::flash('message', 'there was an error fetching language phrases.');
			return redirect()->action('admin\LanguagesController@getAll');
		}
		
		$data1 = $this->CommonData();
		$data2 = [
		    'lang_code' => $code,
		    'lang_file' => $file,
		    'phrases_files' => $this->getPhrasesCategories(),
		    'phrases' => $phrases,
		];
		
		// dd($general_phrases);
		$data = array_merge($data1, $data2);
		return view('admin.editlanguagephrases', $data);
	}
	
	public function postEditPhrases($code, $file){
		
		$input = Input::only('Langkey', 'langPhrase');
		
		$values = [];
		$values[$input['Langkey']] = $input['langPhrase'];
		
		$this->editLangaugeValues($code, $file, $values);
	    
		Session::flash('messageType', 'success');
		Session::flash('message', 'All changes have been applied.');
		
		return redirect()->action('admin\LanguagesController@getEditPhrases', [$code, $file]);
		
	}
	
	private function getPhrasesCategories(){
		$dirs_path = array('resources', 'lang', 'en');
		$dir_path = implode(DIRECTORY_SEPARATOR, $dirs_path);
		
		$dirs = File::files(base_path($dir_path));
		$phrasesCategories = [];
		
		foreach($dirs as $tmpl){
			$tmpl = str_replace(base_path($dir_path), '', $tmpl);
			$tmpl = str_replace('\\', '', $tmpl);
			$tmpl = str_replace('.php', '', $tmpl);
			$phrasesCategories[] = str_replace('/', '', $tmpl);
		}
		
		return $phrasesCategories;
	}
	
	private function copy_directory($src, $dst) {
		$dir = opendir($src);
		@mkdir($dst);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($src . DIRECTORY_SEPARATOR . $file) ) {
					recurse_copy($src . DIRECTORY_SEPARATOR . $file,$dst . DIRECTORY_SEPARATOR . $file);
				}
				else {
					copy($src . DIRECTORY_SEPARATOR . $file,$dst . DIRECTORY_SEPARATOR . $file);
				}
			}
		}
		closedir($dir);
	}
	
}
