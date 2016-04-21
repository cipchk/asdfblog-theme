(function() {

    var findRe = /<(h1|h2)>(.+?)<\/(h1|h2)>/mg,
        showCls = 'active',
        win = $(window);

    function GenNav(options) {
        var self = this;
        self.navPostEl = options.navPostEl;
        self.ci = {};
        self.top = options.top;

        self.apos = [];

        var prevCur = 0;
        $.each(options.con, function() {
            var el = $(this),
                max = el.offset().top + el.height(),
                idVal = el.attr('id').substring(5);

            var titlePoint = self.render(el.find('.post-content'), idVal);

            self.apos.push({
                min: prevCur,
                max: max,
                id: idVal,
                pl: titlePoint
            });

            prevCur = max;
        });
        self.start();
    };

    $.extend(GenNav.prototype, {
        render: function(el, idVal) {
            var self = this,
                html = el.html(),
                resHtml = [],
                resPoint = [],
                resPointPrev = 0,
                point = {
                    h1: 0,
                    h2: 0
                },
                curPoint = 0,
                match = findRe.exec(html);

            while (match !== null) {
                var type = match[1] === 'h1' ? 'dt' : 'dd',
                    fel = el.find('{0}:eq({1})'.format(match[1], point[match[1]]++));

                resHtml.push('<{0}><a href="#navpos-{2}-{3}">{1}</a></{0}>'.format(type, match[2], idVal, curPoint));

                fel.prepend('<a name="navpos-{0}-{1}"></a>'.format(idVal, curPoint));

                resPoint.push({
                    min: resPointPrev,
                    max: fel.offset().top,
                    p: curPoint
                });
                resPointPrev = fel.offset().top;

                ++curPoint;

                match = findRe.exec(html);
            }

            self.navPostEl.append('<dl class="quick-nav" id="navpost-{1}">{0}</dl>'.format(
                resHtml.join(''), idVal));

            return resPoint;
        },
        start: function() {
            var self = this;
            win.on('scroll', $.proxy(self.show, self));
        },
        end: function() {

        },
        show: function() {
            var self = this,
                top = win.scrollTop();

            if (self.top > top) {
                self.navPostEl.hide();
                return;
            } else {
                self.navPostEl.show();
				// 调整位置
				var navCon = self.navPostEl.find('.quick-nav.active');
				if (!navCon.data('top')) {
					var surplusHeight = $(window).height() - navCon.height(),
						top = '5%';
					if (surplusHeight > 10) {
						top = (surplusHeight / 2) + 'px';
					}
					navCon.css({'top': top});
					navCon.data('top', true);
				}
            }

            for (var i = self.apos.length - 1; i >= 0; i--) {
                var item = self.apos[i];
                if (top > item.min && top < item.max && self.ci.id != item.id) {
                    self.change(item);
                    break;
                }
            }

            // 调整已经看过的位置
            if (self.ci.pl) {
                for (var i = self.ci.pl.length - 1; i >= 0; i--) {
                    var item = self.ci.pl[i];
                    if (top > item.min && top < item.max) {
                        self.ci.els.removeClass(showCls).slice(item.p).addClass(showCls);
                        break;
                    }
                }                
            }
        },
        change: function(item) {
            var self = this,
                el = $('#navpost-' + item.id);
            self.ci = item;
            self.ci.els = el.find('a');

            $('.quick-nav.' + showCls).removeClass(showCls);
            el.addClass(showCls);
        }
    });

    var warpEl = $('<div class="quick-nav-wrap"></div>'),
        sidebarEl = $('.sidebar');
    sidebarEl.append(warpEl);
    new GenNav({
        con: $('.post'),
        navPostEl: warpEl,
        top: sidebarEl.find('.header').height() + sidebarEl.find('.widgets').height() + 50
    });

    $('.quick-nav').first().addClass(showCls);


})();
