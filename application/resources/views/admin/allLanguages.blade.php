@extends('admin.layout')

@section('title', 'manage languages')
@section('Alanguages', 'active')

@section('css')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/admin/css/nestable/nestable.css') }}" />
@endsection

@section('content')

            <!-- BEGIN CONTENT-->
			<div id="content">
				<section>
					<div class="section-body">
					
					<div class="row">
					    <div class="col-sm-12">
						 <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#settingsModal"><i class="md md-settings"></i> Settings</button>
					     <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#defaultLanguageModal"><i class="md md-stars"></i> Set default</button>
					     <button type="button" class="btn ink-reaction btn-primary" data-toggle="modal" data-target="#addLanguageModal"><i class="md md-add"></i> Add new</button>
						</div>
					</div><br/>

						@if(Session::has('message'))
							<div class="row">
								<div class="col-sm-12">
									<div class="alert alert-dismissible @if(Session::get('messageType') == 'success') alert-success @else alert-danger @endif" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										{{ Session::get('message') }}
									</div>
								</div>
							</div>
						@endif
					
									<div class="box box-primary box-solid">
										<div class="box-header with-border">
											<h3 class="box-title">All languages</h3>
											<!-- /.box-tools -->
										</div>
									<div class="box-body">
									
									<table class="table table-hover">
							<thead>
								<tr>
									<th>Language name</th>
									<th>Native</th>
									<th>Script</th>
									<th>Regional</th>
									<th class="text-right">Actions</th>
								</tr>
							</thead>
							<tbody>
							@foreach($languages['supportedLocales'] as $key => $Clang)
								<tr>
									<td>{{ $Clang['name'] }} @if($key == Config::get('app.locale'))<i class="fa fa-asterisk text-warning"></i>@endif</td>
									<td>{{ $Clang['native'] }}</td>
									<td>{{ $Clang['script'] }}</td>
									<td>{{ $Clang['regional'] }}</td>
									<td class="text-right">
										<a href="{{ URL::action('admin\LanguagesController@getEditPhrases', [$key, 'general']) }}"><button class="btn">edit phrases</button></a>
										<button onclick="deleteModel('{{ $key }}');" type="button" data-toggle="modal" data-target="#deleteModal" class="btn btn-icon-toggle"><i class="fa fa-trash-o"></i></button>
									</td>
								</tr>
						   @endforeach
							</tbody>
						</table>
									</div><!--end .card-body -->
								</div><!--end .card -->
								
						   <em class="text-caption"><i class="fa fa-asterisk text-warning"></i> Default language.</em>
				      </div><!--end .section-body -->
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->
			
			
<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="defaultLanguageModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Set default language</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\LanguagesController@postAll') }}" method="post">
				<div class="modal-body">
				    <div class="contain-xs floating-label">
											    <div class="col-sm-12">
												<div class="form-group">
												<select id="select1" name="defaultLanguage" class="form-control">
												@foreach($languages['supportedLocales'] as $key => $Clang)
												    <option value="{{ $key }}" @if($key == Config::get('app.locale')) selected @endif>{{ $Clang['name'] }}</option>
												@endforeach
												</select>
											    </div>
											    </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitDefaultLang" value="submit" class="btn btn-primary">Set</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->	
		
<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="addLanguageModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Activate new language</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\LanguagesController@postAll') }}" method="post">
				<div class="modal-body">
				    <div class="contain-xs floating-label">
											    <div class="col-sm-12">
												<div class="form-group">
												<select id="select1" name="newLanguage" class="form-control">
												                                                    <option value="en"  selected >English</option>
																								    <option value="ar" >Arabic</option>
																								    <option value="ace" >Achinese</option>
																								    <option value="af" >Afrikaans</option>
																								    <option value="agq" >Aghem</option>
																								    <option value="ak" >Akan</option>
																								    <option value="an" >Aragonese</option>
																								    <option value="cch" >Atsam</option>
																								    <option value="gn" >Guaran&iacute;</option>
																								    <option value="ae" >Avestan</option>
																								    <option value="ay" >Aymara</option>
																								    <option value="az" >Azerbaijani (Latin)</option>
																								    <option value="id" >Indonesian</option>
																								    <option value="ms" >Malay</option>
																								    <option value="bm" >Bambara</option>
																								    <option value="jv" >Javanese (Latin)</option>
																								    <option value="su" >Sundanese</option>
																								    <option value="bh" >Bihari</option>
																								    <option value="bi" >Bislama</option>
																								    <option value="nb" >Norwegian Bokm&aring;l</option>
																								    <option value="bs" >Bosnian</option>
																								    <option value="br" >Breton</option>
																								    <option value="ca" >Catalan</option>
																								    <option value="ch" >Chamorro</option>
																								    <option value="ny" >Chewa</option>
																								    <option value="kde" >Makonde</option>
																								    <option value="sn" >Shona</option>
																								    <option value="co" >Corsican</option>
																								    <option value="cy" >Welsh</option>
																								    <option value="da" >Danish</option>
																								    <option value="se" >Northern Sami</option>
																								    <option value="de" >German</option>
																								    <option value="luo" >Luo</option>
																								    <option value="nv" >Navajo</option>
																								    <option value="dua" >Duala</option>
																								    <option value="et" >Estonian</option>
																								    <option value="na" >Nauru</option>
																								    <option value="guz" >Ekegusii</option>
																								    <option value="en-AU" >Australian English</option>
																								    <option value="en-GB" >British English</option>
																								    <option value="en-US" >U.S. English</option>
																								    <option value="es" >Spanish</option>
																								    <option value="eo" >Esperanto</option>
																								    <option value="eu" >Basque</option>
																								    <option value="ewo" >Ewondo</option>
																								    <option value="ee" >Ewe</option>
																								    <option value="fil" >Filipino</option>
																								    <option value="fr" >French</option>
																								    <option value="fr-CA" >Canadian French</option>
																								    <option value="fy" >Western Frisian</option>
																								    <option value="fur" >Friulian</option>
																								    <option value="fo" >Faroese</option>
																								    <option value="gaa" >Ga</option>
																								    <option value="ga" >Irish</option>
																								    <option value="gv" >Manx</option>
																								    <option value="sm" >Samoan</option>
																								    <option value="gl" >Galician</option>
																								    <option value="ki" >Kikuyu</option>
																								    <option value="gd" >Scottish Gaelic</option>
																								    <option value="ha" >Hausa</option>
																								    <option value="bez" >Bena</option>
																								    <option value="ho" >Hiri Motu</option>
																								    <option value="hr" >Croatian</option>
																								    <option value="bem" >Bemba</option>
																								    <option value="io" >Ido</option>
																								    <option value="ig" >Igbo</option>
																								    <option value="rn" >Rundi</option>
																								    <option value="ia" >Interlingua</option>
																								    <option value="iu-Latn" >Inuktitut (Latin)</option>
																								    <option value="sbp" >Sileibi</option>
																								    <option value="nd" >North Ndebele</option>
																								    <option value="nr" >South Ndebele</option>
																								    <option value="xh" >Xhosa</option>
																								    <option value="zu" >Zulu</option>
																								    <option value="it" >Italian</option>
																								    <option value="ik" >Inupiaq</option>
																								    <option value="dyo" >Jola-Fonyi</option>
																								    <option value="kea" >Kabuverdianu</option>
																								    <option value="kaj" >Jju</option>
																								    <option value="mh" >Marshallese</option>
																								    <option value="kl" >Kalaallisut</option>
																								    <option value="kln" >Kalenjin</option>
																								    <option value="kr" >Kanuri</option>
																								    <option value="kcg" >Tyap</option>
																								    <option value="kw" >Cornish</option>
																								    <option value="naq" >Nama</option>
																								    <option value="rof" >Rombo</option>
																								    <option value="kam" >Kamba</option>
																								    <option value="kg" >Kongo</option>
																								    <option value="jmc" >Machame</option>
																								    <option value="rw" >Kinyarwanda</option>
																								    <option value="asa" >Kipare</option>
																								    <option value="rwk" >Rwa</option>
																								    <option value="saq" >Samburu</option>
																								    <option value="ksb" >Shambala</option>
																								    <option value="swc" >Congo Swahili</option>
																								    <option value="sw" >Swahili</option>
																								    <option value="dav" >Dawida</option>
																								    <option value="teo" >Teso</option>
																								    <option value="khq" >Koyra Chiini</option>
																								    <option value="ses" >Songhay</option>
																								    <option value="mfe" >Morisyen</option>
																								    <option value="ht" >Haitian</option>
																								    <option value="kj" >Kuanyama</option>
																								    <option value="ksh" >K&ouml;lsch</option>
																								    <option value="ebu" >Kiembu</option>
																								    <option value="mer" >Kim&icirc;&icirc;ru</option>
																								    <option value="lag" >Langi</option>
																								    <option value="lah" >Lahnda</option>
																								    <option value="la" >Latin</option>
																								    <option value="lv" >Latvian</option>
																								    <option value="to" >Tongan</option>
																								    <option value="lt" >Lithuanian</option>
																								    <option value="li" >Limburgish</option>
																								    <option value="ln" >Lingala</option>
																								    <option value="lg" >Ganda</option>
																								    <option value="luy" >Oluluyia</option>
																								    <option value="lb" >Luxembourgish</option>
																								    <option value="hu" >Hungarian</option>
																								    <option value="mgh" >Makhuwa-Meetto</option>
																								    <option value="mg" >Malagasy</option>
																								    <option value="mt" >Maltese</option>
																								    <option value="mtr" >Mewari</option>
																								    <option value="mua" >Mundang</option>
																								    <option value="mi" >Māori</option>
																								    <option value="nl" >Dutch</option>
																								    <option value="nmg" >Kwasio</option>
																								    <option value="yav" >Yangben</option>
																								    <option value="nn" >Norwegian Nynorsk</option>
																								    <option value="oc" >Occitan</option>
																								    <option value="ang" >Old English</option>
																								    <option value="xog" >Soga</option>
																								    <option value="om" >Oromo</option>
																								    <option value="ng" >Ndonga</option>
																								    <option value="hz" >Herero</option>
																								    <option value="uz-Latn" >Uzbek (Latin)</option>
																								    <option value="nds" >Low German</option>
																								    <option value="pl" >Polish</option>
																								    <option value="pt" >Portuguese</option>
																								    <option value="pt-BR" >Brazilian Portuguese</option>
																								    <option value="ff" >Fulah</option>
																								    <option value="pi" >Pahari-Potwari</option>
																								    <option value="aa" >Afar</option>
																								    <option value="ty" >Tahitian</option>
																								    <option value="ksf" >Bafia</option>
																								    <option value="ro" >Romanian</option>
																								    <option value="cgg" >Chiga</option>
																								    <option value="rm" >Romansh</option>
																								    <option value="qu" >Quechua</option>
																								    <option value="nyn" >Nyankole</option>
																								    <option value="ssy" >Saho</option>
																								    <option value="sc" >Sardinian</option>
																								    <option value="de-CH" >Swiss High German</option>
																								    <option value="gsw" >Swiss German</option>
																								    <option value="trv" >Taroko</option>
																								    <option value="seh" >Sena</option>
																								    <option value="nso" >Northern Sotho</option>
																								    <option value="st" >Southern Sotho</option>
																								    <option value="tn" >Tswana</option>
																								    <option value="sq" >Albanian</option>
																								    <option value="sid" >Sidamo</option>
																								    <option value="ss" >Swati</option>
																								    <option value="sk" >Slovak</option>
																								    <option value="sl" >Slovene</option>
																								    <option value="so" >Somali</option>
																								    <option value="sr-Latn" >Serbian (Latin)</option>
																								    <option value="sh" >Serbo-Croatian</option>
																								    <option value="fi" >Finnish</option>
																								    <option value="sv" >Swedish</option>
																								    <option value="sg" >Sango</option>
																								    <option value="tl" >Tagalog</option>
																								    <option value="tzm-Latn" >Central Atlas Tamazight (Latin)</option>
																								    <option value="kab" >Kabyle</option>
																								    <option value="twq" >Tasawaq</option>
																								    <option value="shi" >Tachelhit (Latin)</option>
																								    <option value="nus" >Nuer</option>
																								    <option value="vi" >Vietnamese</option>
																								    <option value="tg-Latn" >Tajik (Latin)</option>
																								    <option value="lu" >Luba-Katanga</option>
																								    <option value="ve" >Venda</option>
																								    <option value="tw" >Twi</option>
																								    <option value="tr" >Turkish</option>
																								    <option value="ale" >Aleut</option>
																								    <option value="ca-valencia" >Valencian</option>
																								    <option value="vai-Latn" >Vai (Latin)</option>
																								    <option value="vo" >Volap&uuml;k</option>
																								    <option value="fj" >Fijian</option>
																								    <option value="wa" >Walloon</option>
																								    <option value="wae" >Walser</option>
																								    <option value="wen" >Sorbian</option>
																								    <option value="wo" >Wolof</option>
																								    <option value="ts" >Tsonga</option>
																								    <option value="dje" >Zarma</option>
																								    <option value="yo" >Yoruba</option>
																								    <option value="de-AT" >Austrian German</option>
																								    <option value="is" >Icelandic</option>
																								    <option value="cs" >Czech</option>
																								    <option value="bas" >Basa</option>
																								    <option value="mas" >Masai</option>
																								    <option value="haw" >Hawaiian</option>
																								    <option value="el" >Greek</option>
																								    <option value="uz" >Uzbek (Cyrillic)</option>
																								    <option value="az-Cyrl" >Azerbaijani (Cyrillic)</option>
																								    <option value="ab" >Abkhazian</option>
																								    <option value="os" >Ossetic</option>
																								    <option value="ky" >Kyrgyz</option>
																								    <option value="sr" >Serbian (Cyrillic)</option>
																								    <option value="av" >Avaric</option>
																								    <option value="ady" >Adyghe</option>
																								    <option value="ba" >Bashkir</option>
																								    <option value="be" >Belarusian</option>
																								    <option value="bg" >Bulgarian</option>
																								    <option value="kv" >Komi</option>
																								    <option value="mk" >Macedonian</option>
																								    <option value="mn" >Mongolian (Cyrillic)</option>
																								    <option value="ce" >Chechen</option>
																								    <option value="ru" >Russian</option>
																								    <option value="sah" >Yakut</option>
																								    <option value="tt" >Tatar</option>
																								    <option value="tg" >Tajik (Cyrillic)</option>
																								    <option value="tk" >Turkmen</option>
																								    <option value="uk" >Ukrainian</option>
																								    <option value="cv" >Chuvash</option>
																								    <option value="cu" >Church Slavic</option>
																								    <option value="kk" >Kazakh</option>
																								    <option value="hy" >Armenian</option>
																								    <option value="yi" >Yiddish</option>
																								    <option value="he" >Hebrew</option>
																								    <option value="ug" >Uyghur</option>
																								    <option value="ur" >Urdu</option>
																								    <option value="uz-Arab" >Uzbek (Arabic)</option>
																								    <option value="tg-Arab" >Tajik (Arabic)</option>
																								    <option value="sd" >Sindhi</option>
																								    <option value="fa" >Persian</option>
																								    <option value="pa-Arab" >Punjabi (Arabic)</option>
																								    <option value="ps" >Pashto</option>
																								    <option value="ks" >Kashmiri (Arabic)</option>
																								    <option value="ku" >Kurdish</option>
																								    <option value="dv" >Divehi</option>
																								    <option value="ks-Deva" >Kashmiri (Devaganari)</option>
																								    <option value="kok" >Konkani</option>
																								    <option value="doi" >Dogri</option>
																								    <option value="ne" >Nepali</option>
																								    <option value="pra" >Prakrit</option>
																								    <option value="brx" >Bodo</option>
																								    <option value="bra" >Braj</option>
																								    <option value="mr" >Marathi</option>
																								    <option value="mai" >Maithili</option>
																								    <option value="raj" >Rajasthani</option>
																								    <option value="sa" >Sanskrit</option>
																								    <option value="hi" >Hindi</option>
																								    <option value="as" >Assamese</option>
																								    <option value="bn" >Bengali</option>
																								    <option value="mni" >Manipuri</option>
																								    <option value="pa" >Punjabi (Gurmukhi)</option>
																								    <option value="gu" >Gujarati</option>
																								    <option value="or" >Oriya</option>
																								    <option value="ta" >Tamil</option>
																								    <option value="te" >Telugu</option>
																								    <option value="kn" >Kannada</option>
																								    <option value="ml" >Malayalam</option>
																								    <option value="si" >Sinhala</option>
																								    <option value="th" >Thai</option>
																								    <option value="lo" >Lao</option>
																								    <option value="bo" >Tibetan</option>
																								    <option value="dz" >Dzongkha</option>
																								    <option value="my" >Burmese</option>
																								    <option value="ka" >Georgian</option>
																								    <option value="byn" >Blin</option>
																								    <option value="tig" >Tigre</option>
																								    <option value="ti" >Tigrinya</option>
																								    <option value="am" >Amharic</option>
																								    <option value="wal" >Wolaytta</option>
																								    <option value="chr" >Cherokee</option>
																								    <option value="iu" >Inuktitut (Canadian Aboriginal Syllabics)</option>
																								    <option value="oj" >Ojibwa</option>
																								    <option value="cr" >Cree</option>
																								    <option value="km" >Khmer</option>
																								    <option value="mn-Mong" >Mongolian (Mongolian)</option>
																								    <option value="shi-Tfng" >Tachelhit (Tifinagh)</option>
																								    <option value="tzm" >Central Atlas Tamazight (Tifinagh)</option>
																								    <option value="yue" >Yue</option>
																								    <option value="ja" >Japanese</option>
																								    <option value="zh" >Chinese (Simplified)</option>
																								    <option value="zh-Hant" >Chinese (Traditional)</option>
																								    <option value="ii" >Sichuan Yi</option>
																								    <option value="vai" >Vai (Vai)</option>
																								    <option value="jv-Java" >Javanese (Javanese)</option>
																								    <option value="ko" >Korean</option>

												</select>
											    </div>
											    </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitAddLang" value="submit" class="btn btn-primary">Activate</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->		


<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Deactivate language</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\LanguagesController@postAll') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-12">
						    <input name="LangCode" type="hidden" id="deleteLangCode">
							<p>Are you sure you want to deactivate this language? you can activate it lather.</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitDeleteLang" value="submit" class="btn btn-primary">Deactivate</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->


<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Languages settings</h4>
			</div>
			<form class="form-horizontal" role="form" action="{{ URL::action('admin\LanguagesController@postAll') }}" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="col-sm-12">
							<div class="checkbox">
								<input type="checkbox" name="langHeader" id="langHeader" value="1" @if($languages['useAcceptLanguageHeader']) checked @endif class="minimal">
								<label for="langHeader">Accept-Language header</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<div class="checkbox">
								<input type="checkbox" name="langURL" id="langURL" value="1" @if($languages['hideDefaultLocaleInURL']) checked @endif class="minimal">
								<label for="langURL">hide default language in URL</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" name="submitLangSettings" value="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->

@endsection

@section('javascript')
<script>
function deleteModel($id){
	$('#deleteLangCode').val($id);
}
</script>
@endsection