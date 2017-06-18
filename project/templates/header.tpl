<div id="header">
		
			<div style="position: absolute; left: 900px; top: 2px;">
				<img src="img/2012.jpg" width="140" height="180" />
			</div>
			
			<div style="position: absolute; right: 150px; top: 2px;">
			{if $lang == 'kz'}<span class="selectedLang">КАЗ</span>{else}<a class="notSelectedLang" href="?page={$page}&id={$id}&language=kaz">КАЗ</a>{/if}
			{if $lang == 'ru'}<span class="selectedLang">РУС</span>{else}<a class="notSelectedLang" href="?page={$page}&id={$id}&language=rus">РУС</a>{/if}
			{if $lang == 'en'}<span class="selectedLang">ENG</span>{else}<a class="notSelectedLang"href="?page={$page}&id={$id}&language=eng">ENG</a>{/if}
			
			
			
			</div>
			{if $statistics_on == 0}
			<div style='background-color: yellow;position: absolute; top: 10px;'>
			statistics off<br/> 
			include_metrica:{$include_metrica}<br/> 
			server_name: {$server_name}<br/>
			</div>
			{/if}
			
			{if $include_metrica == 1}
			<div style="position: absolute; right: 150px; top: 70px;">
							{literal}
						<!-- Yandex.Metrika informer -->
				<a href="https://metrika.yandex.ru/stat/?id=32127900&amp;from=informer"
				target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/32127900/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
				style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:32127900,lang:'ru'});return false}catch(e){}" /></a>
				<!-- /Yandex.Metrika informer -->
				
				<!-- Yandex.Metrika counter -->
				<script type="text/javascript">
				    (function (d, w, c) {
				        (w[c] = w[c] || []).push(function() {
				            try {
				                w.yaCounter32127900 = new Ya.Metrika({
				                    id:32127900,
				                    clickmap:true,
				                    trackLinks:true,
				                    accurateTrackBounce:true
				                });
				            } catch(e) { }
				        });
				
				        var n = d.getElementsByTagName("script")[0],
				            s = d.createElement("script"),
				            f = function () { n.parentNode.insertBefore(s, n); };
				        s.type = "text/javascript";
				        s.async = true;
				        s.src = "https://mc.yandex.ru/metrika/watch.js";
				
				        if (w.opera == "[object Opera]") {
				            d.addEventListener("DOMContentLoaded", f, false);
				        } else { f(); }
				    })(document, window, "yandex_metrika_callbacks");
				</script>
				<noscript><div><img src="https://mc.yandex.ru/watch/32127900" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
				<!-- /Yandex.Metrika counter -->
							
				
	{/literal}
	<!-- Google analytics -->
				{literal}
				<script>
				  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
				
				  ga('create', 'UA-66720550-1', 'auto');
				  ga('send', 'pageview');

				</script>
				{/literal}
				<!-- Google analytics -->
			</div>
		 {/if}
			
			<div class="logoheader">

				<h1 id="logo">
					<nobr>{$text['journal_name']}</nobr>
					<span class="header1"> <nobr> {$text['created_in_year']}</nobr><br />
						<br /> <nobr>
							<font
								style="font-size: 9pt; font-style: italic; font-weight: bold;">
								{$text['ISSN']}</font>
						</nobr><br />
					</span>
				</h1>

			</div>
            
		</div>
		<!-- end header -->