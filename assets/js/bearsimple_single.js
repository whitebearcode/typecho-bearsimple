    //复制
      document.body.oncopy = function() {
         
          $('body').toast({
							    title:'复制成功',
							    class: 'green',
							    message: '若要转载请务必保留原文链接！', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
										});
          };
          if(Mathjax === '1'){
              $.getScript("//cdn.staticfile.org/mathjax/2.7.9/MathJax.js?config=TeX-AMS-MML_HTMLorMML", function() {
            MathJax.Hub.Config({
                tex2jax: {
                    inlineMath: [
                        ['$', '$'],
                        ['\\(', '\\)']
                    ]
                }
            });
          
            MathJax.Hub.Config({
                showProcessingMessages: false,
                messageStyle: "none",
                extensions: ["tex2jax.js"],
                jax: ["input/TeX", "output/HTML-CSS"],
                tex2jax: {
                    inlineMath: [
                        ["$", "$"]
                    ],
                    displayMath: [
                        ["$$", "$$"]
                    ],
                    skipTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code', 'a']
                },
                "HTML-CSS": {
                    availableFonts: ["STIX", "TeX"],
                    showMathMenu: false
                }
            });
            
});


}
        