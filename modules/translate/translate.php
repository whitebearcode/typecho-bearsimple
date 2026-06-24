  <div class="foot-setting-item global">
  <div class="foot-setting-label">
    <i class="fas fa-globe"></i>
    <span>全球语言</span>
  </div>
  <select id="language-select" class="language-select">
      <option value="chinese_simplified">简体中文</option>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('chinese_traditional',Bsoptions('WorldLanguage'))): ?>
      <option value="chinese_traditional">繁体中文</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('german',Bsoptions('WorldLanguage'))): ?>
      <option value="german">Deutsch</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('corsican',Bsoptions('WorldLanguage'))): ?>
      <option value="corsican">Corsu</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('guarani',Bsoptions('WorldLanguage'))): ?>
      <option value="guarani">Guarani</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('kinyarwanda',Bsoptions('WorldLanguage'))): ?>
      <option value="kinyarwanda">Kinyarwanda</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hausa',Bsoptions('WorldLanguage'))): ?>
      <option value="hausa">Hausa</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('norwegian',Bsoptions('WorldLanguage'))): ?>
      <option value="norwegian">Norge</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('dutch',Bsoptions('WorldLanguage'))): ?>
      <option value="dutch">Nederlands</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('yoruba',Bsoptions('WorldLanguage'))): ?>
      <option value="yoruba">Yoruba</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('english',Bsoptions('WorldLanguage'))): ?>
      <option value="english">English</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('gongen',Bsoptions('WorldLanguage'))): ?>
      <option value="gongen">गोंगेन हें नांव</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('latin',Bsoptions('WorldLanguage'))): ?>
      <option value="latin">Latina</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('nepali',Bsoptions('WorldLanguage'))): ?>
      <option value="nepali">नेपाली</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('french',Bsoptions('WorldLanguage'))): ?>
      <option value="french">Français</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('czech',Bsoptions('WorldLanguage'))): ?>
      <option value="czech">čeština</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hawaiian',Bsoptions('WorldLanguage'))): ?>
      <option value="hawaiian">ʻŌlelo Hawaiʻi</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('georgian',Bsoptions('WorldLanguage'))): ?>
      <option value="georgian">ჯორჯიანი</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('russian',Bsoptions('WorldLanguage'))): ?>
      <option value="russian">Русский</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('persian',Bsoptions('WorldLanguage'))): ?>
      <option value="persian">فارسی</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('bhojpuri',Bsoptions('WorldLanguage'))): ?>
      <option value="bhojpuri">भोजपुरी</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hindi',Bsoptions('WorldLanguage'))): ?>
      <option value="hindi">हिंदी</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('belarusian',Bsoptions('WorldLanguage'))): ?>
      <option value="belarusian">беларускі</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('swahili',Bsoptions('WorldLanguage'))): ?>
      <option value="swahili">Kiswahili</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('icelandic',Bsoptions('WorldLanguage'))): ?>
      <option value="icelandic">Íslenska</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('yiddish',Bsoptions('WorldLanguage'))): ?>
      <option value="yiddish">ייַדיש</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('twi',Bsoptions('WorldLanguage'))): ?>
      <option value="twi">Twi</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('irish',Bsoptions('WorldLanguage'))): ?>
      <option value="irish">Gaeilge</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('gujarati',Bsoptions('WorldLanguage'))): ?>
      <option value="gujarati">ગુજરાતી</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('khmer',Bsoptions('WorldLanguage'))): ?>
      <option value="khmer">ខ្មែរ</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('slovak',Bsoptions('WorldLanguage'))): ?>
      <option value="slovak">Slovenčina</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hebrew',Bsoptions('WorldLanguage'))): ?>
      <option value="hebrew">עברית</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('kannada',Bsoptions('WorldLanguage'))): ?>
      <option value="kannada">ಕನ್ನಡ</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hungarian',Bsoptions('WorldLanguage'))): ?>
      <option value="hungarian">Magyar</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('tamil',Bsoptions('WorldLanguage'))): ?>
      <option value="tamil">தமிழ்</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('arabic',Bsoptions('WorldLanguage'))): ?>
      <option value="arabic">العربية</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('bengali',Bsoptions('WorldLanguage'))): ?>
      <option value="bengali">বাংলা</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('azerbaijani',Bsoptions('WorldLanguage'))): ?>
      <option value="azerbaijani">Azərbaycan</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('samoan',Bsoptions('WorldLanguage'))): ?>
      <option value="samoan">Samoan</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('afrikaans',Bsoptions('WorldLanguage'))): ?>
      <option value="afrikaans">Afrikaans</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('indonesian',Bsoptions('WorldLanguage'))): ?>
      <option value="indonesian">Bahasa Indonesia</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('danish',Bsoptions('WorldLanguage'))): ?>
      <option value="danish">Dansk</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('shona',Bsoptions('WorldLanguage'))): ?>
      <option value="shona">Shona</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('bambara',Bsoptions('WorldLanguage'))): ?>
      <option value="bambara">Bamanankan</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('lithuanian',Bsoptions('WorldLanguage'))): ?>
      <option value="lithuanian">Lietuvių</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('vietnamese',Bsoptions('WorldLanguage'))): ?>
      <option value="vietnamese">Tiếng Việt</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('maltese',Bsoptions('WorldLanguage'))): ?>
      <option value="maltese">Malti</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('turkmen',Bsoptions('WorldLanguage'))): ?>
      <option value="turkmen">Türkmen</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('assamese',Bsoptions('WorldLanguage'))): ?>
      <option value="assamese">অসমীয়া</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('catalan',Bsoptions('WorldLanguage'))): ?>
      <option value="catalan">Català</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('singapore',Bsoptions('WorldLanguage'))): ?>
      <option value="singapore">Singapore</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('cebuano',Bsoptions('WorldLanguage'))): ?>
      <option value="cebuano">Cebuano</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('scottish-gaelic',Bsoptions('WorldLanguage'))): ?>
      <option value="scottish-gaelic">Gàidhlig</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('sanskrit',Bsoptions('WorldLanguage'))): ?>
      <option value="sanskrit">संस्कृत</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('polish',Bsoptions('WorldLanguage'))): ?>
      <option value="polish">Polski</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('galician',Bsoptions('WorldLanguage'))): ?>
      <option value="galician">Galego</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('latvian',Bsoptions('WorldLanguage'))): ?>
      <option value="latvian">Latviešu</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('ukrainian',Bsoptions('WorldLanguage'))): ?>
      <option value="ukrainian">Українська</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('tatar',Bsoptions('WorldLanguage'))): ?>
      <option value="tatar">Татар</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('welsh',Bsoptions('WorldLanguage'))): ?>
      <option value="welsh">Cymraeg</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('japanese',Bsoptions('WorldLanguage'))): ?>
      <option value="japanese">日本語</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('filipino',Bsoptions('WorldLanguage'))): ?>
      <option value="filipino">Filipino</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('aymara',Bsoptions('WorldLanguage'))): ?>
      <option value="aymara">Aymara</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('lao',Bsoptions('WorldLanguage'))): ?>
      <option value="lao">ລາວ</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('telugu',Bsoptions('WorldLanguage'))): ?>
      <option value="telugu">తెలుగు</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('romanian',Bsoptions('WorldLanguage'))): ?>
      <option value="romanian">Română</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('haitian_creole',Bsoptions('WorldLanguage'))): ?>
      <option value="haitian_creole">Kreyòl Ayisyen</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('dogrid',Bsoptions('WorldLanguage'))): ?>
      <option value="dogrid">डोग्रिड</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('swedish',Bsoptions('WorldLanguage'))): ?>
      <option value="swedish">Svenska</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('maithili',Bsoptions('WorldLanguage'))): ?>
      <option value="maithili">मैथिली</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('thai',Bsoptions('WorldLanguage'))): ?>
      <option value="thai">ไทย</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('armenian',Bsoptions('WorldLanguage'))): ?>
      <option value="armenian">Հայերեն</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('burmese',Bsoptions('WorldLanguage'))): ?>
      <option value="burmese">မြန်မာ</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('pashto',Bsoptions('WorldLanguage'))): ?>
      <option value="pashto">پښتو</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('hmong',Bsoptions('WorldLanguage'))): ?>
      <option value="hmong">Hmoob</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('dhivehi',Bsoptions('WorldLanguage'))): ?>
      <option value="dhivehi">ދިވެހި</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('luxembourgish',Bsoptions('WorldLanguage'))): ?>
      <option value="luxembourgish">Lëtzebuergesch</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('sindhi',Bsoptions('WorldLanguage'))): ?>
      <option value="sindhi">سنڌي</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('kurdish',Bsoptions('WorldLanguage'))): ?>
      <option value="kurdish">Kurdî</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('turkish',Bsoptions('WorldLanguage'))): ?>
      <option value="turkish">Türkçe</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('macedonian',Bsoptions('WorldLanguage'))): ?>
      <option value="macedonian">Македонски</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('bulgarian',Bsoptions('WorldLanguage'))): ?>
      <option value="bulgarian">Български</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('malay',Bsoptions('WorldLanguage'))): ?>
      <option value="malay">Bahasa Melayu</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('luganda',Bsoptions('WorldLanguage'))): ?>
      <option value="luganda">Luganda</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('marathi',Bsoptions('WorldLanguage'))): ?>
      <option value="marathi">मराठी</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('estonian',Bsoptions('WorldLanguage'))): ?>
      <option value="estonian">Eesti</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('malayalam',Bsoptions('WorldLanguage'))): ?>
      <option value="malayalam">മലയാളം</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('slovene',Bsoptions('WorldLanguage'))): ?>
      <option value="slovene">Slovenščina</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('urdu',Bsoptions('WorldLanguage'))): ?>
      <option value="urdu">اردو</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('portuguese',Bsoptions('WorldLanguage'))): ?>
      <option value="portuguese">Português</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('igbo',Bsoptions('WorldLanguage'))): ?>
      <option value="igbo">Igbo</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('kurdish_sorani',Bsoptions('WorldLanguage'))): ?>
      <option value="kurdish_sorani">کوردی-سۆرانی</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('oromo',Bsoptions('WorldLanguage'))): ?>
      <option value="oromo">Oromoo</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('greek',Bsoptions('WorldLanguage'))): ?>
      <option value="greek">Ελληνικά</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('spanish',Bsoptions('WorldLanguage'))): ?>
      <option value="spanish">Español</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('frisian',Bsoptions('WorldLanguage'))): ?>
      <option value="frisian">Frysk</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('somali',Bsoptions('WorldLanguage'))): ?>
      <option value="somali">Soomaali</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('amharic',Bsoptions('WorldLanguage'))): ?>
      <option value="amharic">አማርኛ</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('nyanja',Bsoptions('WorldLanguage'))): ?>
      <option value="nyanja">Nyanja</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('punjabi',Bsoptions('WorldLanguage'))): ?>
      <option value="punjabi">ਪੰਜਾਬੀ</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('basque',Bsoptions('WorldLanguage'))): ?>
      <option value="basque">Euskara</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('italian',Bsoptions('WorldLanguage'))): ?>
      <option value="italian">Italiano</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('albanian',Bsoptions('WorldLanguage'))): ?>
      <option value="albanian">Shqip</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('korean',Bsoptions('WorldLanguage'))): ?>
      <option value="korean">한국어</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('tajik',Bsoptions('WorldLanguage'))): ?>
      <option value="tajik">Тоҷикӣ</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('finnish',Bsoptions('WorldLanguage'))): ?>
      <option value="finnish">Suomi</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('kyrgyz',Bsoptions('WorldLanguage'))): ?>
      <option value="kyrgyz">Кыргызча</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('ewe',Bsoptions('WorldLanguage'))): ?>
      <option value="ewe">Eʋegbe</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('croatian',Bsoptions('WorldLanguage'))): ?>
      <option value="croatian">Hrvatski</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('creole',Bsoptions('WorldLanguage'))): ?>
      <option value="creole">Kreyòl</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('quechua',Bsoptions('WorldLanguage'))): ?>
      <option value="quechua">Quechua</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('bosnian',Bsoptions('WorldLanguage'))): ?>
      <option value="bosnian">Bosanski</option>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('WorldLanguage')[0]) && @in_array('maori',Bsoptions('WorldLanguage'))): ?>
      <option value="maori">Māori</option>
    <?php endif; ?>
    <?php if(empty(Bsoptions('WorldLanguage'))): ?>
      <option disabled>暂未找到可选语言</option>
    <?php endif; ?>
  </select>
</div>
<script>
$(document).ready(function() {
  const savedLanguage = localStorage.getItem('selectedLanguage');

  if (savedLanguage) {
    $('#language-select').val(savedLanguage);
  }

  // 监听语言选择的变化
  $('#language-select').on('change', function () {
    const selectedLanguage = $(this).val();

    localStorage.setItem('selectedLanguage', selectedLanguage);

    translate.changeLanguage(selectedLanguage);
  });
});
</script>