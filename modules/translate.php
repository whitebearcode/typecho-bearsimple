   <div class="ui floating dropdown labeled icon mini button ignore">
  <i class="language icon"></i>
  <span class="text">选择语言</span>
  <div class="menu" style="overflow-y:scroll;height:150px;">

  <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('chinese_simplified',Bsoptions('WorldLanguage'))):?>
       <a href="javascript:translate.changeLanguage('chinese_simplified');" class="item">简体中文</a>
       <?php endif; ?> 
       <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('chinese_traditional',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('chinese_traditional');" class="item">繁体中文</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('german',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('german');" class="item">Deutsch</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('corsican',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('corsican');" class="item">Corsu</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('guarani',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('guarani');" class="item">guarani</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('kinyarwanda',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('kinyarwanda');" class="item">Kinyarwanda</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hausa',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('hausa');" class="item">Hausa</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('norwegian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('norwegian');" class="item">Norge</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('dutch',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('dutch');" class="item">Nederlands</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('yoruba',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('yoruba');" class="item">Yoruba</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('english',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('english');" class="item">English</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('gongen',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('gongen');" class="item">गोंगेन हें नांव</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('latin',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('latin');" class="item">Latina</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('nepali',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('nepali');" class="item">नेपालीName</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('french',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('french');" class="item">Français</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('czech',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('czech');" class="item">čeština</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hawaiian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('hawaiian');" class="item">ʻŌlelo Hawaiʻi</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('georgian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('georgian');" class="item">ჯორჯიანიName</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('russian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('russian');" class="item">Русский язык</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('persian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('persian');" class="item">فارسی</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('bhojpuri',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('bhojpuri');" class="item">भोजपुरी</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hindi',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('hindi');" class="item">हिंदी</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('belarusian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('belarusian');" class="item">беларускі</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('swahili',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('swahili');" class="item">Kiswahili</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('icelandic',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('icelandic');" class="item">ÍslandName</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('yiddish',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('yiddish');" class="item">ייַדיש</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('twi',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('twi');" class="item">tur</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('irish',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('irish');" class="item">Gaeilge</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('gujarati',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('gujarati');" class="item">ગુજરાતી</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('khmer',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('khmer');" class="item">ខ្មែរK</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('slovak',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('slovak');" class="item">Slovenská</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hebrew',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('hebrew');" class="item">היברית</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('kannada',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('kannada');" class="item">ಕನ್ನಡ್Name</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hungarian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('hungarian');" class="item">Magyar</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('tamil',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('tamil');" class="item">தாமில்</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('arabic',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('arabic');" class="item">بالعربية</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('bengali',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('bengali');" class="item">বাংলা</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('azerbaijani',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('azerbaijani');" class="item">Azərbaycan</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('samoan',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('samoan');" class="item">lifiava</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('afrikaans',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('afrikaans');" class="item">Suid-Afrikaanse Dutch taal</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('indonesian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('indonesian');" class="item">IndonesiaName</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('danish',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('danish');" class="item">dansk</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('shona',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('shona');" class="item">Shona</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('bambara',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('bambara');" class="item">Bamanankan</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('lithuanian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('lithuanian');" class="item">Lietuva</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('vietnamese',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('vietnamese');" class="item">Tiếng Việt</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('maltese',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('maltese');" class="item">Malti</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('turkmen',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('turkmen');" class="item">Türkmençe</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('assamese',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('assamese');" class="item">অসমীয়া</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('catalan',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('catalan');" class="item">català</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('singapore',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('singapore');" class="item">සිංගාපුර්</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('cebuano',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('cebuano');" class="item">Cebuano</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('scottish-gaelic',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('scottish-gaelic');" class="item">Gàidhlig na h-Alba</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('sanskrit',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('sanskrit');" class="item">Sanskrit</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('polish',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('polish');" class="item">Polski</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('galician',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('galician');" class="item">galego</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('latvian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('latvian');" class="item">latviešu</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('ukrainian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('ukrainian');" class="item">Українська</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('tatar',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('tatar');" class="item">Татар</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('welsh',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('welsh');" class="item">Cymraeg</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('japanese',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('japanese');" class="item">日本語</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('filipino',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('filipino');" class="item">Pilipino</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('aymara',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('aymara');" class="item">Aymara</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('lao',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('lao');" class="item">ກະຣຸນາ</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('telugu',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('telugu');" class="item">తెలుగుQ</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('romanian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('romanian');" class="item">Română</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('haitian_creole',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('haitian_creole');" class="item">Kreyòl ayisyen</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('dogrid',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('dogrid');" class="item">डोग्रिड ने दी</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('swedish',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('swedish');" class="item">Svenska</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('maithili',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('maithili');" class="item">मरातिली</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('thai',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('thai');" class="item">ภาษาไทย</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('armenian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('armenian');" class="item">հայերեն</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('burmese',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('burmese');" class="item">ဗာရမ်</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('pashto',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('pashto');" class="item">پښتو</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hmong',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('hmong');" class="item">Hmoob</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('dhivehi',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('dhivehi');" class="item">ދިވެހި</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('luxembourgish',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('luxembourgish');" class="item">Lëtzebuergesch</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('sindhi',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('sindhi');" class="item">سنڌي</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('kurdish',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('kurdish');" class="item">Kurdî</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('turkish',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('turkish');" class="item">Türkçe</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('macedonian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('macedonian');" class="item">Македонски</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('bulgarian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('bulgarian');" class="item">български</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('malay',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('malay');" class="item">Malay</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('luganda',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('luganda');" class="item">luganda</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('marathi',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('marathi');" class="item">मराठी</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('estonian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('estonian');" class="item">eesti keel</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('malayalam',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('malayalam');" class="item">മലമാലം</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('slovene',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('slovene');" class="item">slovenščina</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('urdu',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('urdu');" class="item">اوردو</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('portuguese',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('portuguese');" class="item">Português</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('igbo',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('igbo');" class="item">igbo</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('kurdish_sorani',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('kurdish_sorani');" class="item">کوردی-سۆرانی</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('oromo',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('oromo');" class="item">adeta</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('greek',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('greek');" class="item">Ελληνικά</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('spanish',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('spanish');" class="item">español</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('frisian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('frisian');" class="item">Frysk</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('somali',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('somali');" class="item">Soomaali</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('amharic',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('amharic');" class="item">አማርኛ</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('nyanja',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('nyanja');" class="item">potakuyan</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('punjabi',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('punjabi');" class="item">ਪੰਜਾਬੀ</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('basque',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('basque');" class="item">euskara</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('italian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('italian');" class="item">Italiano</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('albanian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('albanian');" class="item">albanian</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('korean',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('korean');" class="item">한어</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('tajik',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('tajik');" class="item">ТаjikӣName</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('finnish',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('finnish');" class="item">Suomalainen</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('kyrgyz',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('kyrgyz');" class="item">Кыргыз тили</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('ewe',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('ewe');" class="item">Eʋegbe</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('croatian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('croatian');" class="item">Hrvatski</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('creole',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('creole');" class="item">a n:n</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('quechua',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('quechua');" class="item">Quechua</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('bosnian',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('bosnian');" class="item">bosanski</a>
    <?php endif; ?> 
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('maori',Bsoptions('WorldLanguage'))):?>
    <a href="javascript:translate.changeLanguage('maori');" class="item">Maori</a>
    <?php endif; ?> 
    
    
    <?php if(empty(Bsoptions('WorldLanguage'))):?>
    <div onclick="toastr.warning('暂未找到可以翻译的语言，请稍后再试~~~');return false;" class="item">暂未找到可选语言</div>
    <?php endif; ?> 
  </div>
</div>  
