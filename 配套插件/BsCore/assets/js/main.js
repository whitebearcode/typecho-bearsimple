/* jkOptions Framework | A Simple and Lightweight Typecho Option Framework - v1.0.0*/
/*! This file is auto-generated */
// const _wpUtilSettings = {
//     ajax:{
//         url: ''
//     }
// }
/**
 * @output wp-includes/js/wp-util.js
 */

/* global _wpUtilSettings */

/** @namespace wp */
window.wp = window.wp || {};

(function ($) {
    // Check for the utility settings.
    var settings = typeof _wpUtilSettings === 'undefined' ? {} : _wpUtilSettings;

    /**
     * wp.template( id )
     *
     * Fetch a JavaScript template for an id, and return a templating function for it.
     *
     * @param {string} id A string that corresponds to a DOM element with an id prefixed with "tmpl-".
     *                    For example, "attachment" maps to "tmpl-attachment".
     * @return {function} A function that lazily-compiles the template requested.
     */
    wp.template = _.memoize(function ( id ) {
        var compiled,
            /*
             * Underscore's default ERB-style templates are incompatible with PHP
             * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
             *
             * @see trac ticket #22344.
             */
            options = {
                evaluate:    /<#([\s\S]+?)#>/g,
                interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                escape:      /\{\{([^\}]+?)\}\}(?!\})/g,
                variable:    'data'
            };

        return function ( data ) {
            compiled = compiled || _.template( $( '#tmpl-' + id ).html(),  options );
            return compiled( data );
        };
    });

    /*
     * wp.ajax
     * ------
     *
     * Tools for sending ajax requests with JSON responses and built in error handling.
     * Mirrors and wraps jQuery's ajax APIs.
     */
    wp.ajax = {
        settings: settings.ajax || {},

        /**
         * wp.ajax.post( [action], [data] )
         *
         * Sends a POST request to WordPress.
         *
         * @param {(string|Object)} action The slug of the action to fire in WordPress or options passed
         *                                 to jQuery.ajax.
         * @param {Object=}         data   Optional. The data to populate $_POST with.
         * @return {$.promise} A jQuery promise that represents the request,
         *                     decorated with an abort() method.
         */
        post: function( action, data ) {
            return wp.ajax.send({
                data: _.isObject( action ) ? action : _.extend( data || {}, { action: action })
            });
        },

        /**
         * wp.ajax.send( [action], [options] )
         *
         * Sends a POST request to WordPress.
         *
         * @param {(string|Object)} action  The slug of the action to fire in WordPress or options passed
         *                                  to jQuery.ajax.
         * @param {Object=}         options Optional. The options passed to jQuery.ajax.
         * @return {$.promise} A jQuery promise that represents the request,
         *                     decorated with an abort() method.
         */
        send: function( action, options ) {
            var promise, deferred;
            if ( _.isObject( action ) ) {
                options = action;
            } else {
                options = options || {};
                options.data = _.extend( options.data || {}, { action: action });
            }

            options = _.defaults( options || {}, {
                type:    'POST',
                url:     wp.ajax.settings.url,
                context: this
            });

            deferred = $.Deferred( function( deferred ) {
                // Transfer success/error callbacks.
                if ( options.success ) {
                    deferred.done( options.success );
                }

                if ( options.error ) {
                    deferred.fail( options.error );
                }

                delete options.success;
                delete options.error;

                // Use with PHP's wp_send_json_success() and wp_send_json_error().
                deferred.jqXHR = $.ajax( options ).done( function( response ) {
                    // Treat a response of 1 as successful for backward compatibility with existing handlers.
                    if ( response === '1' || response === 1 ) {
                        response = { success: true };
                    }
                    console.log(response)
                    if ( _.isObject( response ) && ! _.isUndefined( response.success ) ) {

                        // When handling a media attachments request, get the total attachments from response headers.
                        var context = this;
                        deferred.done( function() {
                            if (
                                action &&
                                action.data &&
                                'query-attachments' === action.data.action &&
                                deferred.jqXHR.hasOwnProperty( 'getResponseHeader' ) &&
                                deferred.jqXHR.getResponseHeader( 'X-WP-Total' )
                            ) {
                                context.totalAttachments = parseInt( deferred.jqXHR.getResponseHeader( 'X-WP-Total' ), 10 );
                            } else {
                                context.totalAttachments = 0;
                            }
                        } );
                        deferred[ response.success ? 'resolveWith' : 'rejectWith' ]( this, [response.data] );
                    } else {
                        deferred.rejectWith( this, [response] );
                    }
                }).fail( function() {
                    deferred.rejectWith( this, arguments );
                });
            });

            promise = deferred.promise();
            promise.abort = function() {
                deferred.jqXHR.abort();
                return this;
            };

            return promise;
        }
    };

    /*
     *  onecircle ajax
     */
    function oc_empty(value = '') {
        if (value === '' || value === null || value === undefined || value == 0) {
            return true
        }
        else {
            return false
        }
    }
    function setNotice_(msg) {
        $("#authorization_form .ajax-notice").html('<p style="color:#fd4c73;">'+msg+'</p>')
    }
    $("#authorization_submit").on('click',function (e) {
        e.preventDefault();
        let url = $("#authorization_form").data('ajaxurl')
        let action = $("input[name='action']").val()
        if (action === "get_ocpro_authorization"){
            let key_code = $("input[name='key_code']").val()
            if (oc_empty(key_code)){
                setNotice_('缺少参数')
                return false
            }
            $.post(url,{
                do:action,
                key:key_code
            },function (res) {
                if (res.code !== 1){
                    setNotice_(res.msg)
                } else {
                    window.location.reload()
                }
            })
        } else if (action === "get_ocpro_delete_authorization"){
            const ret = confirm('是否删除授权？');
            if (ret){
                $.post(url,{
                    do:action,
                },function (res) {
                    if (res.code !== 1){
                        setNotice_(res.msg)
                    } else {
                        window.location.reload()
                    }
                })
            }

        }
    })
}(jQuery));


!function (I, _, b, y) {
    "use strict";
    var T = T || {};

    T.funcs = {}, T.vars = {
        onloaded: !1,
        $body: I("body"),
        $window: I(_),
        $document: I(b),
        $form_warning: null,
        is_confirm: !1,
        form_modified: !1,
        code_themes: [],
        is_rtl: I("body").hasClass("rtl")
    }, T.helper = {
        uid: function (e) {
            return (e || "") + Math.random().toString(36).substr(2, 9)
        }, preg_quote: function (e) {
            return (e + "").replace(/(\[|\])/g, "\\$1")
        }, name_nested_replace: function (e, t) {
            var n = new RegExp(T.helper.preg_quote(t + "[\\d+]"), "g");
            e.find(":radio").each(function () {
                (this.checked || this.orginal_checked) && (this.orginal_checked = !0)
            }), e.each(function (e) {
                I(this).find(":input").each(function () {
                    this.name = this.name.replace(n, t + "[" + e + "]"), this.orginal_checked && (this.checked = !0)
                })
            })
        }, debounce: function (i, a, s) {
            var c;
            return function () {
                var e = this, t = arguments, n = s && !c;
                clearTimeout(c), c = setTimeout(function () {
                    c = null, s || i.apply(e, t)
                }, a), n && i.apply(e, t)
            }
        }
    }, I.fn.csf_clone = function () {
        for (var e = I.fn.clone.apply(this, arguments), t = this.find("select").add(this.filter("select")), n = e.find("select").add(e.filter("select")), i = 0; i < t.length; ++i) for (var a = 0; a < t[i].options.length; ++a) !0 === t[i].options[a].selected && (n[i].options[a].selected = !0);
        return this.find(":radio").each(function () {
            this.orginal_checked = this.checked
        }), e
    }, I.fn.csf_expand_all = function () {
        return this.each(function () {
            I(this).on("click", function (e) {
                e.preventDefault(), I(".csf-wrapper").toggleClass("csf-show-all"), I(".csf-section").csf_reload_script(), I(this).find(".fa").toggleClass("fa-indent").toggleClass("fa-outdent")
            })
        })
    }, I.fn.csf_nav_options = function () {
        return this.each(function () {
            var a, e = I(this), t = I(_), s = I("#wpwrap"), c = e.find("a");

            t.on("hashchange csf.hashchange", function () {

                var e = _.location.hash.replace("#tab=", ""),
                    t = decodeURI(e || c.first().attr("href").replace("#tab=", "")),
                    n = I('[data-tab-id="' + t + '"]');
                if (n.length) {
                    n.closest(".csf-tab-item").addClass("csf-tab-expanded").siblings().removeClass("csf-tab-expanded"), n.next().is("ul") && (t = (n = n.next().find("li").first().find("a")).data("tab-id")), c.removeClass("csf-active"), n.addClass("csf-active"), a && a.addClass("hidden");
                    var i = I('[data-section-id="' + t + '"]');
                    i.removeClass("hidden"), i.csf_reload_script(), I(".csf-section-id").val(i.index() + 1), a = i, s.hasClass("wp-responsive-open") && (I("html, body").animate({scrollTop: i.offset().top - 50}, 200), s.removeClass("wp-responsive-open"))
                }
            }).trigger("csf.hashchange")
        })
    }, I.fn.csf_nav_metabox = function () {
        return this.each(function () {
            var a, e = I(this), s = e.find("a"), c = e.parent().find(".csf-section");
            s.each(function (i) {
                I(this).on("click", function (e) {
                    e.preventDefault();
                    var t = I(this);
                    s.removeClass("csf-active"), t.addClass("csf-active"), a !== y && a.addClass("hidden");
                    var n = c.eq(i);
                    n.removeClass("hidden"), n.csf_reload_script(), a = n
                })
            }), s.first().trigger("click")
        })
    }, I.fn.csf_page_templates = function () {
        this.length && I(b).on("change", ".editor-page-attributes__template select, #page_template", function () {
            var e = I(this).val() || "default";
            I(".csf-page-templates").removeClass("csf-metabox-show").addClass("csf-metabox-hide"), I(".csf-page-" + e.toLowerCase().replace(/[^a-zA-Z0-9]+/g, "-")).removeClass("csf-metabox-hide").addClass("csf-metabox-show")
        })
    }, I.fn.csf_post_formats = function () {
        this.length && I(b).on("change", '.editor-post-format select, #formatdiv input[name="post_format"]', function () {
            var e = I(this).val() || "default";
            e = "0" === e ? "default" : e, I(".csf-post-formats").removeClass("csf-metabox-show").addClass("csf-metabox-hide"), I(".csf-post-format-" + e).removeClass("csf-metabox-hide").addClass("csf-metabox-show")
        })
    }, I.fn.csf_search = function () {
        return this.each(function () {
            var $this  = I(this),
                $input = $this.find('input');

            $input.on('change keyup', function() {

                var value    = $(this).val(),
                    $wrapper = $('.csf-wrapper'),
                    $section = $wrapper.find('.csf-section'),
                    $fields  = $section.find('> .csf-field:not(.csf-depend-on)'),
                    $titles  = $fields.find('> .csf-title, .csf-search-tags');

                if ( value.length > 1 ) { // 3 to 1 兼容中文

                    $fields.addClass('csf-metabox-hide');
                    $wrapper.addClass('csf-search-all');

                    $titles.each( function() {

                        var $title = $(this);

                        if ( $title.text().match( new RegExp('.*?' + value + '.*?', 'i') ) ) {

                            var $field = $title.closest('.csf-field');

                            $field.removeClass('csf-metabox-hide');
                            $field.parent().csf_reload_script();
                        }
                    });
                } else {
                    $fields.removeClass('csf-metabox-hide');
                    $wrapper.removeClass('csf-search-all');
                }
            });

        })
    }, I.fn.csf_sticky = function () {
        return this.each(function () {
            // var i = I(this), a = I(_), s = i.find(".csf-header-inner"),
            //     c = parseInt(s.css("padding-left")) + parseInt(s.css("padding-right")), r = 0, o = !1, e = function () {
            //         o || requestAnimationFrame(function () {
            //             var e, t, n;
            //             e = i.offset().top, t = Math.max(8, e - r), n = a.innerWidth(), t <= 8 && 782 < n ? (s.css({width: i.outerWidth() - c}), i.css({height: i.outerHeight()}).addClass("csf-sticky")) : (s.removeAttr("style"), i.removeAttr("style").removeClass("csf-sticky")), o = !1
            //         }), o = !0
            //     }, t = function () {
            //         r = a.scrollTop(), e()
            //     };
            // a.on("scroll resize", t), t()

            var $this     = I(this),
                $window   = I(window),
                $inner    = $this.find('.csf-header-inner'),
                padding   = parseInt( $inner.css('padding-left') ) + parseInt( $inner.css('padding-right') ),
                offset    = 8,
                scrollTop = 0,
                lastTop   = 0,
                ticking   = false,
                stickyUpdate = function() {

                    var offsetTop = $this.offset().top,
                        stickyTop = Math.max(offset, offsetTop - scrollTop ),
                        winWidth  = $window.innerWidth();

                    if ( stickyTop <= offset && winWidth > 782 ) {
                        $inner.css({width: $this.outerWidth()});
                        $this.css({height: $this.outerHeight()}).addClass( 'csf-sticky' );
                    } else {
                        $inner.removeAttr('style');
                        $this.removeAttr('style').removeClass( 'csf-sticky' );
                    }

                },
                requestTick = function() {

                    if ( !ticking ) {
                        requestAnimationFrame( function() {
                            stickyUpdate();
                            ticking = false;
                        });
                    }

                    ticking = true;

                },
                onSticky  = function() {

                    scrollTop = $window.scrollTop();
                    requestTick();

                };

            $window.on( 'scroll resize', onSticky);

            onSticky();
        })
    },
    $.fn.csf_dependency = function() {
        return this.each( function() {

            var $this   = $(this),
                $fields = $this.children('[data-controller]');

            if( $fields.length ) {

                var normal_ruleset = $.csf_deps.createRuleset(),
                    global_ruleset = $.csf_deps.createRuleset(),
                    normal_depends = [],
                    global_depends = [];

                $fields.each( function() {

                    var $field      = $(this),
                        controllers = $field.data('controller').split('|'),
                        conditions  = $field.data('condition').split('|'),
                        values      = $field.data('value').toString().split('|'),
                        is_global   = $field.data('depend-global') ? true : false,
                        ruleset     = ( is_global ) ? global_ruleset : normal_ruleset;

                    $.each(controllers, function( index, depend_id ) {

                        var value     = values[index] || '',
                            condition = conditions[index] || conditions[0];

                        ruleset = ruleset.createRule('[data-depend-id="'+ depend_id +'"]', condition, value);

                        ruleset.include($field);

                        if ( is_global ) {
                            global_depends.push(depend_id);
                        } else {
                            normal_depends.push(depend_id);
                        }

                    });

                });

                if ( normal_depends.length ) {
                    $.csf_deps.enable($this, normal_ruleset, normal_depends);
                }

                if ( global_depends.length ) {
                    $.csf_deps.enable(T.vars.$body, global_ruleset, global_depends);
                }

            }

        });
    }, I.fn.csf_field_accordion = function () {
        return this.each(function () {
            I(this).find(".csf-accordion-title").on("click", function () {
                var e = I(this), t = e.find(".csf-accordion-icon"), n = e.next();
                t.hasClass("fa-angle-right") ? t.removeClass("fa-angle-right").addClass("fa-angle-down") : t.removeClass("fa-angle-down").addClass("fa-angle-right"), n.data("opened") || (n.csf_reload_script(), n.data("opened", !0)), n.toggleClass("csf-accordion-open")
            })
        })
    }, I.fn.csf_field_backup = function () {
        return this.each(function () {

            var base    = this,
                $this   = $(this),
                $body   = $('body'),
                $import = $this.find('.csf-import'),
                $reset  = $this.find('.csf-reset');


            $reset.on('click', function( e ) {
                e.preventDefault();
                if ( confirm('确定吗') ) {
                    window.wp.ajax.post('csf-reset', {
                        unique: $reset.data('unique'),
                        nonce: $reset.data('nonce')
                    })
                        .done( function( response ) {
                            window.location.reload(true);
                        })
                        .fail( function( response ) {
                            alert( response.error );
                            // wp.customize.notifications.remove('csf_field_backup_notification');
                        });

                }

            });
            $import.on('click', function( e ) {

                e.preventDefault();
                if (confirm('确定吗') ) {
                    // base.notificationOverlay();
                    window.wp.ajax.post( 'csf-import', {
                        unique: $import.data('unique'),
                        nonce: $import.data('nonce'),
                        data: $this.find('.csf-import-data').val()
                    }).done( function( response ) {
                        window.location.reload(true);
                    }).fail( function( response ) {
                        alert( response.error );
                        // wp.customize.notifications.remove('csf_field_backup_notification');
                    });


                }

            });
        })
    }, I.fn.csf_field_background = function () {
        return this.each(function () {
            I(this).find(".csf--background-image").csf_reload_script()
        })
    }, I.fn.csf_field_code_editor = function () {
        return this.each(function () {
            if ("function" == typeof CodeMirror) {
                var t = I(this), i = t.find("textarea"), e = t.find(".CodeMirror"), a = i.data("editor");
                e.length && e.remove();
                var s = setInterval(function () {
                    if (t.is(":visible")) {
                        var n = CodeMirror.fromTextArea(i[0], a);
                        if ("default" !== a.theme && -1 === T.vars.code_themes.indexOf(a.theme)) {
                            var e = I("<link>");
                            I("#csf-codemirror-css").after(e), e.attr({
                                rel: "stylesheet",
                                id: "csf-codemirror-" + a.theme + "-css",
                                href: a.cdnURL + "/theme/" + a.theme + ".min.css",
                                type: "text/css",
                                media: "all"
                            }), T.vars.code_themes.push(a.theme)
                        }
                        CodeMirror.modeURL = a.cdnURL + "/mode/%N/%N.min.js", CodeMirror.autoLoadMode(n, a.mode), n.on("change", function (e, t) {
                            i.val(n.getValue()).trigger("change")
                        }), clearInterval(s)
                    }
                })
            }
        })
    }, I.fn.csf_field_date = function () {
        return this.each(function () {
            var e = I(this), i = e.find("input"), a = e.find(".csf-date-settings").data("settings"), t = {
                showAnim: "", beforeShow: function (e, t) {
                    I(t.dpDiv).addClass("csf-datepicker-wrapper")
                }, onClose: function (e, t) {
                    I(t.dpDiv).removeClass("csf-datepicker-wrapper")
                }
            };
            a = I.extend({}, a, t), 2 === i.length && (a = I.extend({}, a, {
                onSelect: function (e) {
                    I(this), i.first();
                    var t = i.first().attr("id") === I(this).attr("id") ? "minDate" : "maxDate",
                        n = I.datepicker.parseDate(a.dateFormat, e);
                    i.not(this).datepicker("option", t, n)
                }
            })), i.each(function () {
                var e = I(this);
                e.hasClass("hasDatepicker") && e.removeAttr("id").removeClass("hasDatepicker"), e.datepicker(a)
            })
        })
    }, I.fn.csf_field_datetime = function () {
        return this.each(function () {
            var e = I(this), i = e.find("input"), t = e.find(".csf-datetime-settings").data("settings");
            t = I.extend({}, t, {
                onReady: function (e, t, n) {
                    I(n.calendarContainer).addClass("csf-flatpickr")
                }
            }), 2 === i.length && (t = I.extend({}, t, {
                onChange: function (e, t, n) {
                    "from" === I(n.element).data("type") ? i.last().get(0)._flatpickr.set("minDate", e[0]) : i.first().get(0)._flatpickr.set("maxDate", e[0])
                }
            })), i.each(function () {
                I(this).flatpickr(t)
            })
        })
    }, I.fn.csf_field_fieldset = function () {
        return this.each(function () {
            I(this).find(".csf-fieldset-content").csf_reload_script()
        })
    }, I.fn.csf_field_gallery = function () {
        return this.each(function () {

        })
    }, I.fn.csf_field_group = function () {
        return this.each(function () {
            var e = I(this), t = e.children(".csf-fieldset"), n = t.length ? t : e,
                r = n.children(".csf-cloneable-wrapper"), i = n.children(".csf-cloneable-hidden"),
                o = n.children(".csf-cloneable-max"), f = n.children(".csf-cloneable-min"), c = r.data("title-by"),
                l = r.data("title-by-prefix"), d = r.data("field-id"), h = Boolean(Number(r.data("title-number"))),
                p = parseInt(r.data("max")), a = parseInt(r.data("min"));
            r.hasClass("ui-accordion") && r.find(".ui-accordion-header-icon").remove();
            var u = function (e) {
                e.find(".csf-cloneable-title-number").each(function (e) {
                    I(this).html(I(this).closest(".csf-cloneable-item").index() + 1 + ".")
                })
            };
            r.accordion({
                header: "> .csf-cloneable-item > .csf-cloneable-title",
                collapsible: !0,
                active: !1,
                animate: !1,
                heightStyle: "content",
                icons: {
                    header: "csf-cloneable-header-icon fas fa-angle-right",
                    activeHeader: "csf-cloneable-header-icon fas fa-angle-down"
                },
                activate: function (e, t) {
                    var n = t.newPanel, i = t.newHeader;
                    if (n.length && !n.data("opened")) {
                        var a = i.find(".csf-cloneable-value"), s = [];
                        I.each(c, function (e, t) {
                            s.push(n.find('[data-depend-id="' + t + '"]'))
                        }), I.each(s, function (e, t) {
                            t.on("change keyup csf.keyup", function () {
                                var i = [];
                                I.each(s, function (e, t) {
                                    var n = t.val();
                                    n && i.push(n)
                                }), i.length && a.text(i.join(l))
                            }).trigger("csf.keyup")
                        }), n.csf_reload_script(), n.data("opened", !0), n.data("retry", !1)
                    } else n.data("retry") && (n.csf_reload_script_retry(), n.data("retry", !1))
                }
            }), r.sortable({
                axis: "y",
                handle: ".csf-cloneable-title,.csf-cloneable-sort",
                helper: "original",
                cursor: "move",
                placeholder: "widget-placeholder",
                start: function (e, t) {
                    r.accordion({active: !1}), r.sortable("refreshPositions"), t.item.children(".csf-cloneable-content").data("retry", !0)
                },
                update: function (e, t) {
                    T.helper.name_nested_replace(r.children(".csf-cloneable-item"), d), r.csf_customizer_refresh(), h && u(r)
                }
            }), n.children(".csf-cloneable-add").on("click", function (e) {
                e.preventDefault();
                var t = r.children(".csf-cloneable-item").length;
                if (f.hide(), p && p < t + 1) o.show(); else {
                    var n = i.csf_clone(!0);
                    n.removeClass("csf-cloneable-hidden"), n.find(':input[name!="_pseudo"]').each(function () {
                        this.name = this.name.replace("___", "").replace(d + "[0]", d + "[" + t + "]")
                    }), r.append(n), r.accordion("refresh"), r.accordion({active: t}), r.csf_customizer_refresh(), r.csf_customizer_listen({closest: !0}), h && u(r)
                }
            });
            var s = function (e) {
                e.preventDefault();
                var t = r.children(".csf-cloneable-item").length;
                if (f.hide(), p && p < t + 1) o.show(); else {
                    var n = I(this).parent().parent(), i = n.children(".csf-cloneable-helper").csf_clone(!0),
                        a = n.children(".csf-cloneable-title").csf_clone(),
                        s = n.children(".csf-cloneable-content").csf_clone(),
                        c = I('<div class="csf-cloneable-item" />');
                    c.append(i), c.append(a), c.append(s), r.children().eq(n.index()).after(c), T.helper.name_nested_replace(r.children(".csf-cloneable-item"), d), r.accordion("refresh"), r.csf_customizer_refresh(), r.csf_customizer_listen({closest: !0}), h && u(r)
                }
            };
            r.children(".csf-cloneable-item").children(".csf-cloneable-helper").on("click", ".csf-cloneable-clone", s), n.children(".csf-cloneable-hidden").children(".csf-cloneable-helper").on("click", ".csf-cloneable-clone", s);
            var v = function (e) {
                e.preventDefault();
                var t = r.children(".csf-cloneable-item").length;
                o.hide(), f.hide(), a && t - 1 < a ? f.show() : (I(this).closest(".csf-cloneable-item").remove(), T.helper.name_nested_replace(r.children(".csf-cloneable-item"), d), r.csf_customizer_refresh(), h && u(r))
            };
            r.children(".csf-cloneable-item").children(".csf-cloneable-helper").on("click", ".csf-cloneable-remove", v), n.children(".csf-cloneable-hidden").children(".csf-cloneable-helper").on("click", ".csf-cloneable-remove", v)
        })
    }, I.fn.csf_field_icon = function () {
        return this.each(function () {
            var n = I(this);
            n.on("click", ".csf-icon-add", function (e) {
                e.preventDefault();
                var t = I(this), i = I("#csf-modal-icon");
                i.removeClass("hidden"), T.vars.$icon_target = n, T.vars.icon_modal_loaded || (i.find(".csf-modal-loading").show(), _.wp.ajax.post("csf-get-icons", {nonce: t.data("nonce")}).done(function (e) {
                    i.find(".csf-modal-loading").hide(), T.vars.icon_modal_loaded = !0;
                    var n = i.find(".csf-modal-load").html(e.content);
                    n.on("click", "i", function (e) {
                        e.preventDefault();
                        var t = I(this).attr("title");
                        T.vars.$icon_target.find(".csf-icon-preview i").removeAttr("class").addClass(t), T.vars.$icon_target.find(".csf-icon-preview").removeClass("hidden"), T.vars.$icon_target.find(".csf-icon-remove").removeClass("hidden"), T.vars.$icon_target.find("input").val(t).trigger("change"), i.addClass("hidden")
                    }), i.on("change keyup", ".csf-icon-search", function () {
                        var t = I(this).val();
                        n.find("i").each(function () {
                            var e = I(this);
                            e.attr("title").search(new RegExp(t, "i")) < 0 ? e.hide() : e.show()
                        })
                    }), i.on("click", ".csf-modal-close, .csf-modal-overlay", function () {
                        i.addClass("hidden")
                    })
                }).fail(function (e) {
                    i.find(".csf-modal-loading").hide(), i.find(".csf-modal-load").html(e.error), i.on("click", function () {
                        i.addClass("hidden")
                    })
                }))
            }), n.on("click", ".csf-icon-remove", function (e) {
                e.preventDefault(), n.find(".csf-icon-preview").addClass("hidden"), n.find("input").val("").trigger("change"), I(this).addClass("hidden")
            })
        })
    }, I.fn.csf_field_map = function () {
        return this.each(function () {
            if ("undefined" != typeof L) {
                var e = I(this), t = e.find(".csf--map-osm"), n = e.find(".csf--map-search input"),
                    i = e.find(".csf--latitude"), a = e.find(".csf--longitude"), s = e.find(".csf--zoom"),
                    c = t.data("map"), r = L.map(t.get(0), c);
                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(r);
                var o = L.marker(c.center, {draggable: !0}).addTo(r), f = function (e) {
                    i.val(e.lat), a.val(e.lng), s.val(r.getZoom())
                };
                r.on("click", function (e) {
                    o.setLatLng(e.latlng), f(e.latlng)
                }), r.on("zoom", function () {
                    f(o.getLatLng())
                }), o.on("drag", function () {
                    f(o.getLatLng())
                }), n.length || (n = I('[data-depend-id="' + e.find(".csf--address-field").data("address-field") + '"]'));
                var l = {};
                n.autocomplete({
                    source: function (e, n) {
                        var i = e.term;
                        i in l ? n(l[i]) : I.get("https://nominatim.openstreetmap.org/search", {
                            format: "json",
                            q: i
                        }, function (e) {
                            var t;
                            t = e.length ? e.map(function (e) {
                                return {value: e.display_name, label: e.display_name, lat: e.lat, lon: e.lon}
                            }, "json") : [{value: "no-data", label: "No Results."}], l[i] = t, n(t)
                        })
                    }, select: function (e, t) {
                        if ("no-data" === t.item.value) return !1;
                        var n = L.latLng(t.item.lat, t.item.lon);
                        r.panTo(n), o.setLatLng(n), f(n)
                    }, create: function (e, t) {
                        I(this).autocomplete("widget").addClass("csf-map-ui-autocomplate")
                    }
                });
                var d = function () {
                    var e = L.latLng(i.val(), a.val());
                    r.panTo(e), o.setLatLng(e)
                };
                i.on("change", d), a.on("change", d)
            }
        })
    }, I.fn.csf_field_link = function () {
        return this.each(function () {
            var a = I(this), e = a.find(".csf--link"), s = a.find(".csf--add"), c = a.find(".csf--edit"),
                r = a.find(".csf--remove"), o = a.find(".csf--result"), t = T.helper.uid("csf-wplink-textarea-");
            s.on("click", function (e) {
                e.preventDefault(), _.wpLink.open(t)
            }), c.on("click", function (e) {
                e.preventDefault(), s.trigger("click"), I("#wp-link-url").val(a.find(".csf--url").val()), I("#wp-link-text").val(a.find(".csf--text").val()), I("#wp-link-target").prop("checked", "_blank" === a.find(".csf--target").val())
            }), r.on("click", function (e) {
                e.preventDefault(), a.find(".csf--url").val("").trigger("change"), a.find(".csf--text").val(""), a.find(".csf--target").val(""), s.removeClass("hidden"), c.addClass("hidden"), r.addClass("hidden"), o.parent().addClass("hidden")
            }), e.attr("id", t).on("change", function () {
                var e = _.wpLink.getAttrs(), t = e.href, n = I("#wp-link-text").val(), i = e.target ? e.target : "";
                a.find(".csf--url").val(t).trigger("change"), a.find(".csf--text").val(n), a.find(".csf--target").val(i), o.html('{url:"' + t + '", text:"' + n + '", target:"' + i + '"}'), s.addClass("hidden"), c.removeClass("hidden"), r.removeClass("hidden"), o.parent().removeClass("hidden")
            })
        })
    }, I.fn.csf_field_media = function () {
        return this.each(function () {
            var $this            = $(this),
                $upload_button   = $this.find('.csf--button'),
                $remove_button   = $this.find('.csf--remove'),
                $close_modal = $('.media-modal-close'),
                $library         = $upload_button.data('library') && $upload_button.data('library').split(',') || '',
                $auto_attributes = ( $this.hasClass('csf-assign-field-background') ) ? $this.closest('.csf-field-background').find('.csf--auto-attributes') : false,
                wp_media_frame;

            var uploader = $('#__wp-uploader'),
                upload_router = $('#menu-item-upload'),
                upload_tab = $('#menu-item-upload-tab'),
                media_lib_router = $('#menu-item-browse'),
                media_lib_tab = $('#menu-item-browse-tab');

            upload_router.on('click', function (e){
                media_lib_tab.hide()
                media_lib_router.removeClass('active')
                upload_tab.show()
                if (!upload_router.hasClass('active')){
                    upload_router.addClass('active')
                }
            })
            media_lib_router.on('click', function (e){
                upload_tab.hide();
                upload_router.removeClass('active')
                media_lib_tab.show();
                if (!media_lib_router.hasClass('active')){
                    media_lib_router.addClass('active')
                }
            })

            $upload_button.on('click', function( e ) {
                e.preventDefault()
                uploader.toggle()
                window.cur_media_click_instance = $(this);
            });
            $close_modal.on('click', function (e){
                uploader.hide();
            });
            $remove_button.on('click', function( e ) {

                e.preventDefault();

                if ( $auto_attributes ) {
                    $auto_attributes.addClass('csf--attributes-hidden');
                }

                $remove_button.addClass('hidden');
                $this.find('input').val('');
                $this.find('.csf--preview').addClass('hidden');
                $this.find('.csf--url').trigger('change');

            });

        })
    }, I.fn.csf_field_repeater = function () {
        return this.each(function () {
            var e = I(this), t = e.children(".csf-fieldset"), n = t.length ? t : e,
                c = n.children(".csf-repeater-wrapper"), i = n.children(".csf-repeater-hidden"),
                r = n.children(".csf-repeater-max"), o = n.children(".csf-repeater-min"), f = c.data("field-id"),
                l = parseInt(c.data("max")), a = parseInt(c.data("min"));
            c.children(".csf-repeater-item").children(".csf-repeater-content").csf_reload_script(), c.sortable({
                axis: "y",
                handle: ".csf-repeater-sort",
                helper: "original",
                cursor: "move",
                placeholder: "widget-placeholder",
                update: function (e, t) {
                    T.helper.name_nested_replace(c.children(".csf-repeater-item"), f), c.csf_customizer_refresh(), t.item.csf_reload_script_retry()
                }
            }), n.children(".csf-repeater-add").on("click", function (e) {
                e.preventDefault();
                var t = c.children(".csf-repeater-item").length;
                if (o.hide(), l && l < t + 1) r.show(); else {
                    var n = i.csf_clone(!0);
                    n.removeClass("csf-repeater-hidden"), n.find(':input[name!="_pseudo"]').each(function () {
                        this.name = this.name.replace("___", "").replace(f + "[0]", f + "[" + t + "]")
                    }), c.append(n), n.children(".csf-repeater-content").csf_reload_script(), c.csf_customizer_refresh(), c.csf_customizer_listen({closest: !0})
                }
            });
            var s = function (e) {
                e.preventDefault();
                var t = c.children(".csf-repeater-item").length;
                if (o.hide(), l && l < t + 1) r.show(); else {
                    var n = I(this).parent().parent().parent(), i = n.children(".csf-repeater-content").csf_clone(),
                        a = n.children(".csf-repeater-helper").csf_clone(!0),
                        s = I('<div class="csf-repeater-item" />');
                    s.append(i), s.append(a), c.children().eq(n.index()).after(s), s.children(".csf-repeater-content").csf_reload_script(), T.helper.name_nested_replace(c.children(".csf-repeater-item"), f), c.csf_customizer_refresh(), c.csf_customizer_listen({closest: !0})
                }
            };
            c.children(".csf-repeater-item").children(".csf-repeater-helper").on("click", ".csf-repeater-clone", s), n.children(".csf-repeater-hidden").children(".csf-repeater-helper").on("click", ".csf-repeater-clone", s);
            var d = function (e) {
                e.preventDefault();
                var t = c.children(".csf-repeater-item").length;
                r.hide(), o.hide(), a && t - 1 < a ? o.show() : (I(this).closest(".csf-repeater-item").remove(), T.helper.name_nested_replace(c.children(".csf-repeater-item"), f), c.csf_customizer_refresh())
            };
            c.children(".csf-repeater-item").children(".csf-repeater-helper").on("click", ".csf-repeater-remove", d), n.children(".csf-repeater-hidden").children(".csf-repeater-helper").on("click", ".csf-repeater-remove", d)
        })
    }, I.fn.csf_field_slider = function () {
        return this.each(function () {
            var e = I(this), n = e.find("input"), t = e.find(".csf-slider-ui"), i = n.data(), a = n.val() || 0;
            t.hasClass("ui-slider") && t.empty(), t.slider({
                range: "min",
                value: a,
                min: i.min || 0,
                max: i.max || 100,
                step: i.step || 1,
                slide: function (e, t) {
                    n.val(t.value).trigger("change")
                }
            }), n.on("keyup", function () {
                t.slider("value", n.val())
            })
        })
    }, I.fn.csf_field_sortable = function () {
        return this.each(function () {
            var n = I(this).find(".csf-sortable");
            n.sortable({
                axis: "y",
                helper: "original",
                cursor: "move",
                placeholder: "widget-placeholder",
                update: function (e, t) {
                    n.csf_customizer_refresh()
                }
            }), n.find(".csf-sortable-content").csf_reload_script()
        })
    }, I.fn.csf_field_sorter = function () {
        return this.each(function () {
            var i = I(this), e = i.find(".csf-enabled"), t = i.find(".csf-disabled"), n = !!t.length && t;
            e.sortable({
                connectWith: n, placeholder: "ui-sortable-placeholder", update: function (e, t) {
                    var n = t.item.find("input");
                    t.item.parent().hasClass("csf-enabled") ? n.attr("name", n.attr("name").replace("disabled", "enabled")) : n.attr("name", n.attr("name").replace("enabled", "disabled")), i.csf_customizer_refresh()
                }
            }), n && n.sortable({
                connectWith: e, placeholder: "ui-sortable-placeholder", update: function (e, t) {
                    i.csf_customizer_refresh()
                }
            })
        })
    }, I.fn.csf_field_spinner = function () {
        return this.each(function () {
            var e = I(this), n = e.find("input"), t = e.find(".ui-button"), i = n.data();
            t.length && t.remove(), n.spinner({
                min: i.min || 0,
                max: i.max || 100,
                step: i.step || 1,
                create: function (e, t) {
                    i.unit && n.after('<span class="ui-button csf--unit">' + i.unit + "</span>")
                },
                spin: function (e, t) {
                    n.val(t.value).trigger("change")
                }
            })
        })
    }, I.fn.csf_field_switcher = function () {
        return this.each(function () {
            var n = I(this).find(".csf--switcher");
            n.on("click", function () {
                var e = 0, t = n.find("input");
                n.hasClass("csf--active") ? n.removeClass("csf--active") : (e = 1, n.addClass("csf--active")), t.val(e).trigger("change")
            })
        })
    }, I.fn.csf_field_tabbed = function () {
        return this.each(function () {
            var e = I(this), t = e.find(".csf-tabbed-nav a"), a = e.find(".csf-tabbed-content");
            a.eq(0).csf_reload_script(), t.on("click", function (e) {
                e.preventDefault();
                var t = I(this), n = t.index(), i = a.eq(n);
                t.addClass("csf-tabbed-active").siblings().removeClass("csf-tabbed-active"), i.csf_reload_script(), i.removeClass("hidden").siblings().addClass("hidden")
            })
        })
    }, I.fn.csf_field_typography = function () {
        return this.each(function () {
            var j = this, L = I(this), i = [], A = csf_typography_json.webfonts, t = csf_typography_json.googlestyles,
                q = csf_typography_json.defaultstyles;
            j.sanitize_subset = function (e) {
                return e = (e = e.replace("-ext", " Extended")).charAt(0).toUpperCase() + e.slice(1)
            }, j.sanitize_style = function (e) {
                return t[e] ? t[e] : e
            }, j.load_google_font = function (e, t, n) {
                e && "object" == typeof WebFont && (t = t ? t.replace("normal", "") : "", n = n ? n.replace("normal", "") : "", (t || n) && (e = e + ":" + t + n), -1 === i.indexOf(e) && WebFont.load({google: {families: [e]}}), i.push(e))
            }, j.append_select_options = function (e, t, a, s, c) {
                e.find("option").not(":first").remove();
                var r = "";
                I.each(t, function (e, t) {
                    var n, i = t;
                    n = c ? a && -1 !== a.indexOf(t) ? " selected" : "" : a && a === t ? " selected" : "", "subset" === s ? i = j.sanitize_subset(t) : "style" === s && (i = j.sanitize_style(t)), r += '<option value="' + t + '"' + n + ">" + i + "</option>"
                }), e.append(r).trigger("csf.change").trigger("chosen:updated")
            }, j.init = function () {
                var l = [], e = L.find(".csf--typography"), d = L.find(".csf--type"),
                    h = L.find(".csf--block-font-style"), v = e.data("unit"), g = e.data("line-height-unit"),
                    t = e.data("exclude") ? e.data("exclude").split(",") : [];
                L.find(".csf--chosen").length && L.find("select").each(function () {
                    var e = I(this), t = e.parent().find(".chosen-container");
                    t.length && t.remove(), e.chosen({
                        allow_single_deselect: !0,
                        disable_search_threshold: 15,
                        width: "100%"
                    })
                });
                var m = L.find(".csf--font-family"), i = m.val();
                m.find("option").not(":first-child").remove();
                var a = "";
                I.each(A, function (n, e) {
                    t && -1 !== t.indexOf(n) || (a += '<optgroup label="' + e.label + '">', I.each(e.fonts, function (e, t) {
                        a += '<option value="' + (t = "object" == typeof t ? e : t) + '" data-type="' + n + '"' + (t === i ? " selected" : "") + ">" + t + "</option>"
                    }), a += "</optgroup>")
                }), m.append(a).trigger("chosen:updated");
                var p = L.find(".csf--block-font-style");
                if (p.length) {
                    var u = L.find(".csf--font-style-select"), _ = u.val() ? u.val().replace(/normal/g, "") : "";
                    u.on("change csf.change", function (e) {
                        var t = u.val();
                        !t && l && -1 === l.indexOf("normal") && (t = l[0]);
                        var n = t && "italic" !== t && "normal" === t ? "normal" : "",
                            i = t && "italic" !== t && "normal" !== t ? t.replace("italic", "") : n,
                            a = t && "italic" === t.substr(-6) ? "italic" : "";
                        L.find(".csf--font-weight").val(i), L.find(".csf--font-style").val(a)
                    });
                    var b = L.find(".csf--block-extra-styles");
                    if (b.length) var y = L.find(".csf--extra-styles"), w = y.val()
                }
                var C = L.find(".csf--block-subset");
                if (C.length) var k = L.find(".csf--subset"), x = k.val(), z = k.data("multiple") || !1;
                var D = L.find(".csf--block-backup-font-family");
                m.on("change csf.change", function (e) {
                    C.length && C.addClass("hidden"), b.length && b.addClass("hidden"), D.length && D.addClass("hidden");
                    var t = m.find(":selected"), n = t.val(), i = t.data("type");
                    if (i && n) {
                        if ("google" !== i && "custom" !== i || !D.length || D.removeClass("hidden"), p.length) {
                            var a = q;
                            "google" === i && A[i].fonts[n][0] ? a = A[i].fonts[n][0] : "custom" === i && A[i].fonts[n] && (a = A[i].fonts[n]);
                            var s = -1 !== (l = a).indexOf("normal") ? "normal" : a[0],
                                c = _ && -1 !== a.indexOf(_) ? _ : s;
                            j.append_select_options(u, a, c, "style"), _ = !1, p.removeClass("hidden"), "google" === i && b.length && 1 < a.length && (j.append_select_options(y, a, w, "style", !0), w = !1, b.removeClass("hidden"))
                        }
                        if ("google" === i && C.length && A[i].fonts[n][1]) {
                            var r = A[i].fonts[n][1], o = r.length < 2 && "latin" !== r[0] ? r[0] : "",
                                f = x && -1 !== r.indexOf(x) ? x : o;
                            f = z && x ? x : f, j.append_select_options(k, r, f, "subset", z), x = !1, C.removeClass("hidden")
                        }
                    } else h.find(":input").val(""), C.length && (k.find("option").not(":first-child").remove(), k.trigger("chosen:updated")), p.length && (u.find("option").not(":first-child").remove(), u.trigger("chosen:updated"));
                    d.val(i)
                }).trigger("csf.change");
                var O = L.find(".csf--block-preview");
                if (O.length) {
                    var S = L.find(".csf--preview");
                    L.on("change", T.helper.debounce(function (e) {
                        O.removeClass("hidden");
                        var t = m.val(), n = L.find(".csf--font-weight").val(), i = L.find(".csf--font-style").val(),
                            a = L.find(".csf--font-size").val(), s = L.find(".csf--font-variant").val(),
                            c = L.find(".csf--line-height").val(), r = L.find(".csf--text-align").val(),
                            o = L.find(".csf--text-transform").val(), f = L.find(".csf--text-decoration").val(),
                            l = L.find(".csf--color").val(), d = L.find(".csf--word-spacing").val(),
                            h = L.find(".csf--letter-spacing").val(), p = L.find(".csf--custom-style").val();
                        "google" === L.find(".csf--type").val() && j.load_google_font(t, n, i);
                        var u = {};
                        t && (u.fontFamily = t), n && (u.fontWeight = n), i && (u.fontStyle = i), s && (u.fontVariant = s), a && (u.fontSize = a + v), c && (u.lineHeight = c + g), h && (u.letterSpacing = h + v), d && (u.wordSpacing = d + v), r && (u.textAlign = r), o && (u.textTransform = o), f && (u.textDecoration = f), l && (u.color = l), S.removeAttr("style"), p && S.attr("style", p), S.css(u)
                    }, 100)), O.on("click", function () {
                        S.toggleClass("csf--black-background");
                        var e = O.find(".csf--toggle");
                        e.hasClass("fa-toggle-off") ? e.removeClass("fa-toggle-off").addClass("fa-toggle-on") : e.removeClass("fa-toggle-on").addClass("fa-toggle-off")
                    }), O.hasClass("hidden") || L.trigger("change")
                }
            }, j.init()
        })
    },  I.fn.csf_field_wp_editor = function () {
        return this.each(function () {
            if (void 0 !== _.wp.editor && void 0 !== _.tinyMCEPreInit && void 0 !== _.tinyMCEPreInit.mceInit.csf_wp_editor) {
                var e = I(this), t = e.find(".csf-wp-editor"), n = e.find("textarea");
                (e.find(".wp-editor-wrap").length || e.find(".mce-container").length) && (t.empty(), t.append(n), n.css("display", ""));
                var i = T.helper.uid("csf-editor-");
                n.attr("id", i);
                var a = {
                    tinymce: _.tinyMCEPreInit.mceInit.csf_wp_editor,
                    quicktags: _.tinyMCEPreInit.qtInit.csf_wp_editor
                }, s = t.data("editor-settings"), c = wp.oldEditor ? wp.oldEditor : wp.editor;
                c && c.hasOwnProperty("autop") && (wp.editor.autop = c.autop, wp.editor.removep = c.removep, wp.editor.initialize = c.initialize);
                a.tinymce = I.extend({}, a.tinymce, {
                    selector: "#" + i, setup: function (t) {
                        t.on("change keyup", function () {
                            var e = s.wpautop ? t.getContent() : wp.editor.removep(t.getContent());
                            n.val(e).trigger("change")
                        })
                    }
                }), !1 === s.tinymce && (a.tinymce = !1, t.addClass("csf-no-tinymce")), !1 === s.quicktags && (a.quicktags = !1, t.addClass("csf-no-quicktags"));
                var r = setInterval(function () {
                    e.is(":visible") && (_.wp.editor.initialize(i, a), clearInterval(r))
                });
                if (s.media_buttons && _.csf_media_buttons) {
                    var o = t.find(".wp-media-buttons");
                    if (o.length) o.find(".csf-shortcode-button").data("editor-id", i); else {
                        var f = I(_.csf_media_buttons);
                        f.find(".csf-shortcode-button").data("editor-id", i), t.prepend(f)
                    }
                }
            }
        })
    }, I.fn.csf_confirm = function () {
        return this.each(function () {
            I(this).on("click", function (e) {
                var t = I(this).data("confirm") || _.csf_vars.i18n.confirm;
                if (!confirm(t)) return e.preventDefault(), !1;
                T.vars.is_confirm = !0, T.vars.form_modified = !1
            })
        })
    }, I.fn.serializeObject = function () {
        var a = {};
        return I.each(this.serializeArray(), function (e, t) {
            var n = t.name, i = t.value;
            a[n] = a[n] === y ? i : I.isArray(a[n]) ? a[n].concat(i) : [a[n], i]
        }), a
    }, I.fn.csf_save = function () {
        return this.each(function () {
            var i, a = I(this), c = I(".csf-save"), r = I(".csf-options"), o = !1;
            a.on("click", function (e) {
                if (!o) {
                    var t = a.data("save"), n = a.val();
                    c.attr("value", t), a.hasClass("csf-save-ajax") ? (e.preventDefault(), r.addClass("csf-saving"), c.prop("disabled", !0), _.wp.ajax.post("csf_" + r.data("unique") + "_ajax_save", {data: I("#csf-form").serializeJSONCSF()}).done(function (e) {
                        if (I(".csf-error").remove(), Object.keys(e.errors).length) {
                            var s = '<i class="csf-label-error csf-error">!</i>';
                            I.each(e.errors, function (e, t) {
                                var n = I('[data-depend-id="' + e + '"]'),
                                    i = I('a[href="#tab=' + n.closest(".csf-section").data("section-id") + '"]'),
                                    a = i.closest(".csf-tab-item");
                                n.closest(".csf-fieldset").append('<p class="csf-error csf-error-text">' + t + "</p>"), i.find(".csf-error").length || i.append(s), a.find(".csf-arrow .csf-error").length || a.find(".csf-arrow").append(s)
                            })
                        }
                        r.removeClass("csf-saving"), c.prop("disabled", !1).attr("value", n), o = !1, T.vars.form_modified = !1, T.vars.$form_warning.hide(), clearTimeout(i);
                        var t = I(".csf-form-success");
                        t.empty().append(e.notice).fadeIn("fast", function () {
                            i = setTimeout(function () {
                                t.fadeOut("fast")
                            }, 1e3)
                        })
                    }).fail(function (e) {
                        alert(e.notice)
                    })) : T.vars.form_modified = !1
                }
                o = !0
            })
        })
    }, I.fn.OCF_Options = function () {
        return this.each(function () {
            var e = I(this), t = e.find(".csf-content"), n = e.find(".csf-form-success"),
                i = e.find(".csf-form-warning"), a = e.find(".csf-header .csf-save");
            (T.vars.$form_warning = i).length && (_.onbeforeunload = function () {
                return !!T.vars.form_modified || y
            }, t.on("change keypress", ":input", function () {
                T.vars.form_modified || (n.hide(), i.fadeIn("fast"), T.vars.form_modified = !0)
            })), n.hasClass("csf-form-show") && setTimeout(function () {
                n.fadeOut("fast")
            }, 1e3), I(b).keydown(function (e) {
                if ((e.ctrlKey || e.metaKey) && 83 === e.which) return a.trigger("click"), e.preventDefault(), !1
            })
        })
    }, I.fn.csf_taxonomy = function () {
        return this.each(function () {
            var e = I(this), t = e.parents("form");
            if ("addtag" === t.attr("id")) {
                var n = t.find("#submit"), i = e.find(".csf-field").csf_clone();
                n.on("click", function () {
                    t.find(".form-required").hasClass("form-invalid") || (e.data("inited", !1), e.empty(), e.html(i), i = i.csf_clone(), e.csf_reload_script())
                })
            }
        })
    }, I.fn.csf_shortcode = function () {
        var m = this;
        return m.shortcode_parse = function (e, n) {
            var i = "";
            return I.each(e, function (e, t) {
                i += "[" + (n = n || e), I.each(t, function (e, t) {
                    "content" === e ? (i += "]", i += t, i += "[/" + n) : i += m.shortcode_tags(e, t)
                }), i += "]"
            }), i
        }, m.shortcode_tags = function (e, t) {
            var n = "";
            return "" !== t && ("object" != typeof t || I.isArray(t) ? n += " " + e + '="' + t.toString() + '"' : I.each(t, function (e, t) {
                switch (e) {
                    case"background-image":
                        t = t.url ? t.url : ""
                }
                "" !== t && (n += " " + e + '="' + t.toString() + '"')
            })), n
        }, m.insertAtChars = function (e, t) {
            var n = void 0 !== e[0].name ? e[0] : e;
            return n.value.length && void 0 !== n.selectionStart ? (n.focus(), n.value.substring(0, n.selectionStart) + t + n.value.substring(n.selectionEnd, n.value.length)) : (n.focus(), t)
        }, m.send_to_editor = function (e, t) {
            var n;
            if ("undefined" != typeof tinymce && (n = tinymce.get(t)), n && !n.isHidden()) n.execCommand("mceInsertContent", !1, e); else {
                var i = I("#" + t);
                i.val(m.insertAtChars(i, e)).trigger("change")
            }
        }, this.each(function () {
            var c, r, o, n, f, l, d, a, h, p = I(this), i = p.find(".csf-modal-load"),
                u = (p.find(".csf-modal-content"), p.find(".csf-modal-insert")), s = p.find(".csf-modal-loading"),
                t = p.find("select"), v = p.data("modal-id"), g = p.data("nonce");
            I(b).on("click", '.csf-shortcode-button[data-modal-id="' + v + '"]', function (e) {
                e.preventDefault(), h = I(this), c = h.data("editor-id") || !1, r = h.data("target-id") || !1, o = h.data("gutenberg-id") || !1, p.removeClass("hidden"), p.hasClass("csf-shortcode-single") && f === y && t.trigger("change")
            }), t.on("change", function () {
                var e = I(this), t = e.find(":selected");
                n = e.val(), f = t.data("shortcode"), l = t.data("view") || "normal", d = t.data("group") || f, i.empty(), n ? (s.show(), _.wp.ajax.post("csf-get-shortcode-" + v, {
                    shortcode_key: n,
                    nonce: g
                }).done(function (e) {
                    s.hide();
                    var t = I(e.content).appendTo(i);
                    u.parent().removeClass("hidden"), a = t.find(".csf--repeat-shortcode").csf_clone(), t.csf_reload_script(), t.find(".csf-fields").csf_reload_script()
                })) : u.parent().addClass("hidden")
            }), u.on("click", function (e) {
                if (e.preventDefault(), !u.prop("disabled") && !u.attr("disabled")) {
                    var i = "",
                        t = p.find(".csf-field:not(.csf-depend-on)").find(":input:not(.ignore)").serializeObjectCSF();
                    switch (l) {
                        case"contents":
                            var n = f ? t[f] : t;
                            I.each(n, function (e, t) {
                                var n = f || e;
                                i += "[" + n + "]" + t + "[/" + n + "]"
                            });
                            break;
                        case"group":
                            i += "[" + f, I.each(t[f], function (e, t) {
                                i += m.shortcode_tags(e, t)
                            }), i += "]", i += m.shortcode_parse(t[d], d), i += "[/" + f + "]";
                            break;
                        case"repeater":
                            i += m.shortcode_parse(t[d], d);
                            break;
                        default:
                            i += m.shortcode_parse(t)
                    }
                    if (i = "" === i ? "[" + f + "]" : i, o) {
                        var a = _.csf_gutenberg_props.attributes.hasOwnProperty("shortcode") ? _.csf_gutenberg_props.attributes.shortcode : "";
                        _.csf_gutenberg_props.setAttributes({shortcode: a + i})
                    } else if (c) m.send_to_editor(i, c); else {
                        var s = r ? I(r) : h.parent().find("textarea");
                        s.val(m.insertAtChars(s, i)).trigger("change")
                    }
                    p.addClass("hidden")
                }
            }), p.on("click", ".csf--repeat-button", function (e) {
                e.preventDefault();
                var t = p.find(".csf--repeatable"), n = a.csf_clone(), i = n.find(".csf-repeat-remove");
                n.appendTo(t);
                n.find(".csf-fields").csf_reload_script(), T.helper.name_nested_replace(p.find(".csf--repeat-shortcode"), d), i.on("click", function () {
                    n.remove(), T.helper.name_nested_replace(p.find(".csf--repeat-shortcode"), d)
                })
            }), p.on("click", ".csf-modal-close, .csf-modal-overlay", function () {
                p.addClass("hidden")
            })
        })
    }, "function" == typeof Color && (Color.prototype.toString = function () {
        if (this._alpha < 1) return this.toCSS("rgba", this._alpha).replace(/\s+/g, "");
        var e = parseInt(this._color, 10).toString(16);
        if (this.error) return "";
        if (e.length < 6) for (var t = 6 - e.length - 1; 0 <= t; t--) e = "0" + e;
        return "#" + e
    }), T.funcs.parse_color = function (e) {
        var t = e.replace(/\s+/g, ""),
            n = -1 !== t.indexOf("rgba") ? parseFloat(100 * t.replace(/^.*,(.+)\)/, "$1")) : 100;
        return {value: t, transparent: n, rgba: n < 100}
    }, I.fn.csf_color = function () {
        return this.each(function () {
            var c, r = I(this), o = T.funcs.parse_color(r.val()),
                e = !_.csf_vars.color_palette.length || _.csf_vars.color_palette;

            r.hasClass("wp-color-picker") && r.closest(".wp-picker-container").after(r).remove(), r.wpColorPicker({
                palettes: e, change: function (e, t) {
                    var n = t.color.toString();
                    c.removeClass("csf--transparent-active"), c.find(".csf--transparent-offset").css("background-color", n), r.val(n).trigger("change")
                }, create: function () {
                    c = r.closest(".wp-picker-container");
                    var i = r.data("a8cIris"),
                        e = I('<div class="csf--transparent-wrap"><div class="csf--transparent-slider"></div><div class="csf--transparent-offset"></div><div class="csf--transparent-text"></div><div class="csf--transparent-button">transparent <i class="fas fa-toggle-off"></i></div></div>').appendTo(c.find(".wp-picker-holder")),
                        a = e.find(".csf--transparent-slider"), s = e.find(".csf--transparent-text"),
                        n = e.find(".csf--transparent-offset"), t = e.find(".csf--transparent-button");
                    "transparent" === r.val() && c.addClass("csf--transparent-active"), t.on("click", function () {
                        "transparent" !== r.val() ? (r.val("transparent").trigger("change").removeClass("iris-error"), c.addClass("csf--transparent-active")) : (r.val(i._color.toString()).trigger("change"), c.removeClass("csf--transparent-active"))
                    }), a.slider({
                        value: o.transparent, step: 1, min: 0, max: 100, slide: function (e, t) {
                            var n = parseFloat(t.value / 100);
                            i._color._alpha = n, r.wpColorPicker("color", i._color.toString()), s.text(1 === n || 0 === n ? "" : n)
                        }, create: function () {
                            var e = parseFloat(o.transparent / 100), t = e < 1 ? e : "";
                            s.text(t), n.css("background-color", o.value), c.on("click", ".wp-picker-clear", function () {
                                i._color._alpha = 1, s.text(""), a.slider("option", "value", 100), c.removeClass("csf--transparent-active"), r.trigger("change")
                            }), c.on("click", ".wp-picker-default", function () {
                                var e = T.funcs.parse_color(r.data("default-color")),
                                    t = parseFloat(e.transparent / 100), n = t < 1 ? t : "";
                                i._color._alpha = t, s.text(n), a.slider("option", "value", e.transparent), "transparent" === e.value && (r.removeClass("iris-error"), c.addClass("csf--transparent-active"))
                            })
                        }
                    })
                }
            })
        })
    }, I.fn.csf_chosen = function () {
        return this.each(function () {
            var s = I(this), e = s.parent().find(".chosen-container"), t = s.hasClass("csf-chosen-sortable") || !1,
                n = s.hasClass("csf-chosen-ajax") || !1, i = s.attr("multiple") || !1, a = i ? "100%" : "auto",
                c = I.extend({
                    allow_single_deselect: !0,
                    disable_search_threshold: 10,
                    width: a,
                    no_results_text: _.csf_vars.i18n.no_results_text
                }, s.data("chosen-settings"));
            if (e.length && e.remove(), n) {
                var r = I.extend({
                    data: {type: "post", nonce: ""},
                    allow_single_deselect: !0,
                    disable_search_threshold: -1,
                    width: "100%",
                    min_length: 2,
                    type_delay: 500,
                    typing_text: _.csf_vars.i18n.typing_text,
                    searching_text: _.csf_vars.i18n.searching_text,
                    no_results_text: _.csf_vars.i18n.no_results_text
                }, s.data("chosen-settings"));
                s.CSFAjaxChosen(r)
            } else s.chosen(c);
            if (i) {
                var o = s.parent().find(".csf-hide-select"), f = o.val() || [];
                s.on("change", function (e, t) {
                    t && t.selected ? o.append('<option value="' + t.selected + '" selected="selected">' + t.selected + "</option>") : t && t.deselected && o.find('option[value="' + t.deselected + '"]').remove(), _.wp.customize !== y && 0 === o.children().length && o.data("customize-setting-link") && _.wp.customize.control(o.data("customize-setting-link")).setting.set(""), o.trigger("change")
                }), s.CSFChosenOrder(f, !0)
            }
            if (t) {
                var l = s.parent().find(".chosen-container").find(".chosen-choices");
                l.bind("mousedown", function (e) {
                    I(e.target).is("span") && e.stopPropagation()
                }), l.sortable({
                    items: "li:not(.search-field)",
                    helper: "orginal",
                    cursor: "move",
                    placeholder: "search-choice-placeholder",
                    start: function (e, t) {
                        t.placeholder.width(t.item.innerWidth()), t.placeholder.height(t.item.innerHeight())
                    },
                    update: function (e, t) {
                        var i = "", a = s.data("chosen"), n = s.parent().find(".csf-hide-select");
                        l.find(".search-choice-close").each(function () {
                            var n = I(this).data("option-array-index");
                            I.each(a.results_data, function (e, t) {
                                t.array_index === n && (i += '<option value="' + t.value + '" selected>' + t.value + "</option>")
                            })
                        }), n.children().remove(), n.append(i), n.trigger("change")
                    }
                })
            }
        })
    }, I.fn.csf_checkbox = function () {
        return this.each(function () {
            var e = I(this), t = e.find(".csf--input"), n = e.find(".csf--checkbox");
            n.on("click", function () {
                t.val(Number(n.prop("checked"))).trigger("change")
            })
        })
    }, I.fn.csf_siblings = function () {
        return this.each(function () {
            var t = I(this), e = t.find(".csf--sibling"), n = t.data("multiple") || !1;
            e.on("click", function () {
                var e = I(this);
                n ? e.hasClass("csf--active") ? (e.removeClass("csf--active"), e.find("input").prop("checked", !1).trigger("change")) : (e.addClass("csf--active"), e.find("input").prop("checked", !0).trigger("change")) : (t.find("input").prop("checked", !1), e.find("input").prop("checked", !0).trigger("change"), e.addClass("csf--active").siblings().removeClass("csf--active"))
            })
        })
    }, I.fn.csf_help = function () {
        return this.each(function () {
            var e, t, n = I(this);
            n.on({
                mouseenter: function () {
                    e = I('<div class="csf-tooltip"></div>').html(n.find(".csf-help-text").html()).appendTo("body"), t = T.vars.is_rtl ? n.offset().left + 24 : n.offset().left - e.outerWidth(), e.css({
                        top: n.offset().top - (e.outerHeight() / 2 - 14),
                        left: t
                    })
                }, mouseleave: function () {
                    e !== y && e.remove()
                }
            })
        })
    }, I.fn.csf_customizer_refresh = function () {
        return this.each(function () {
            var e = I(this), t = e.closest(".csf-customize-complex");
            if (t.length) {
                var n = t.data("unique-id");
                if (n === y) return;
                var i = t.find(":input"), a = t.data("option-id"), s = i.serializeObjectCSF(),
                    c = !I.isEmptyObject(s) && s[n] && s[n][a] ? s[n][a] : "",
                    r = _.wp.customize.control(n + "[" + a + "]");
                r.setting._value = null, r.setting.set(c)
            } else e.find(":input").first().trigger("change");
            I(b).trigger("csf-customizer-refresh", e)
        })
    }, I.fn.csf_customizer_listen = function (e) {
        var t = I.extend({closest: !1}, e);
        return this.each(function () {
            if (_.wp.customize !== y) {
                var n = t.closest ? I(this).closest(".csf-customize-complex") : I(this), e = n.find(":input"),
                    i = n.data("unique-id"), a = n.data("option-id");
                i !== y && e.on("change keyup csf.change", function () {
                    var e = n.find(":input").serializeObjectCSF(),
                        t = !I.isEmptyObject(e) && e[i] && e[i][a] ? e[i][a] : "";
                    _.wp.customize.control(i + "[" + a + "]").setting.set(t)
                })
            }
        })
    }, I(b).on("expanded", ".control-section", function () {
        var e = I(this);
        if (e.hasClass("open") && !e.data("inited")) {
            var t = e.find(".csf-customize-field"), n = e.find(".csf-customize-complex");
            t.length && (e.csf_dependency(), t.csf_reload_script({dependency: !1}), n.csf_customizer_listen()), e.data("inited", !0)
        }
    }), T.vars.$window.on("resize csf.resize", T.helper.debounce(function (e) {
        (-1 < navigator.userAgent.indexOf("AppleWebKit/") ? T.vars.$window.width() : _.innerWidth) <= 782 && !T.vars.onloaded && (I(".csf-section").csf_reload_script(), T.vars.onloaded = !0)
    }, 200)).trigger("csf.resize"), I.fn.csf_widgets = function () {
        return this.each(function () {
            I(b).on("widget-added widget-updated", function (e, t) {
                var n = t.find(".csf-fields");
                n.length && n.csf_reload_script()
            }), I(b).on("click", ".widget-top", function (e) {
                var t = I(this).parent().find(".csf-fields");
                t.length && t.csf_reload_script()
            }), I(".widgets-sortables, .control-section-sidebar").on("sortstop", function (e, t) {
                t.item.find(".csf-fields").csf_reload_script_retry()
            })
        })
    }, I.fn.csf_nav_menu = function () {
        return this.each(function () {
            var e = I(this);
            e.on("click", "a.item-edit", function () {
                I(this).closest("li.menu-item").find(".csf-fields").csf_reload_script()
            }), e.on("sortstop", function (e, t) {
                t.item.find(".csf-fields").csf_reload_script_retry()
            })
        })
    }, I.fn.csf_reload_script_retry = function () {
        return this.each(function () {
            var e = I(this);
            e.data("inited") && e.children(".csf-field-wp_editor").csf_field_wp_editor()
        })
    }, I.fn.csf_reload_script = function (e) {
        var t = I.extend({dependency: !0}, e);
        return this.each(function () {
            var e = I(this);
            e.data("inited") || (e.children(".csf-field-accordion").csf_field_accordion(), e.children(".csf-field-backup").csf_field_backup(), e.children(".csf-field-background").csf_field_background(), e.children(".csf-field-code_editor").csf_field_code_editor(), e.children(".csf-field-date").csf_field_date(), e.children(".csf-field-datetime").csf_field_datetime(), e.children(".csf-field-fieldset").csf_field_fieldset(), e.children(".csf-field-gallery").csf_field_gallery(), e.children(".csf-field-group").csf_field_group(), e.children(".csf-field-icon").csf_field_icon(), e.children(".csf-field-link").csf_field_link(), e.children(".csf-field-media").csf_field_media(), e.children(".csf-field-map").csf_field_map(), e.children(".csf-field-repeater").csf_field_repeater(), e.children(".csf-field-slider").csf_field_slider(), e.children(".csf-field-sortable").csf_field_sortable(), e.children(".csf-field-sorter").csf_field_sorter(), e.children(".csf-field-spinner").csf_field_spinner(), e.children(".csf-field-switcher").csf_field_switcher(), e.children(".csf-field-tabbed").csf_field_tabbed(), e.children(".csf-field-typography").csf_field_typography(), e.children(".csf-field-upload").csf_field_media(), e.children(".csf-field-wp_editor").csf_field_wp_editor(), e.children(".csf-field-border").find(".csf-color").csf_color(), e.children(".csf-field-background").find(".csf-color").csf_color(), e.children(".csf-field-color").find(".csf-color").csf_color(), e.children(".csf-field-color_group").find(".csf-color").csf_color(), e.children(".csf-field-link_color").find(".csf-color").csf_color(), e.children(".csf-field-typography").find(".csf-color").csf_color(), e.children(".csf-field-select").find(".csf-chosen").csf_chosen(), e.children(".csf-field-checkbox").find(".csf-checkbox").csf_checkbox(), e.children(".csf-field-button_set").find(".csf-siblings").csf_siblings(), e.children(".csf-field-image_select").find(".csf-siblings").csf_siblings(), e.children(".csf-field-palette").find(".csf-siblings").csf_siblings(), e.children(".csf-field").find(".csf-help").csf_help(), t.dependency && e.csf_dependency(), e.data("inited", !0), I(b).trigger("csf-reload-script", e))
        })
    }, I(b).ready(function () {
        I(".csf-save").csf_save(), I(".csf-options").OCF_Options(), I(".csf-sticky-header").csf_sticky(), I(".csf-nav-options").csf_nav_options(), I(".csf-nav-metabox").csf_nav_metabox(), I(".csf-taxonomy").csf_taxonomy(), I(".csf-page-templates").csf_page_templates(), I(".csf-post-formats").csf_post_formats(), I(".csf-shortcode").csf_shortcode(), I(".csf-search").csf_search(), I(".csf-confirm").csf_confirm(), I(".csf-expand-all").csf_expand_all(), I(".csf-onload").csf_reload_script(), I("#widgets-editor").csf_widgets(), I("#widgets-right").csf_widgets(), I("#menu-to-edit").csf_nav_menu()
    })
}(jQuery, window, document);

// jquery url add query paramter
new function(settings) {
    // Various Settings
    var $separator = settings.separator || '&';
    var $spaces = settings.spaces === false ? false : true;
    var $suffix = settings.suffix === false ? '' : '[]';
    var $prefix = settings.prefix === false ? false : true;
    var $hash = $prefix ? settings.hash === true ? "#" : "?" : "";
    var $numbers = settings.numbers === false ? false : true;

    jQuery.query = new function() {
        var is = function(o, t) {
            return o != undefined && o !== null && (!!t ? o.constructor == t : true);
        };
        var parse = function(path) {
            var m, rx = /\[([^[]*)\]/g, match = /^([^[]+)(\[.*\])?$/.exec(path), base = match[1], tokens = [];
            while (m = rx.exec(match[2])) tokens.push(m[1]);
            return [base, tokens];
        };
        var set = function(target, tokens, value) {
            var o, token = tokens.shift();
            if (typeof target != 'object') target = null;
            if (token === "") {
                if (!target) target = [];
                if (is(target, Array)) {
                    target.push(tokens.length == 0 ? value : set(null, tokens.slice(0), value));
                } else if (is(target, Object)) {
                    var i = 0;
                    while (target[i++] != null);
                    target[--i] = tokens.length == 0 ? value : set(target[i], tokens.slice(0), value);
                } else {
                    target = [];
                    target.push(tokens.length == 0 ? value : set(null, tokens.slice(0), value));
                }
            } else if (token && token.match(/^\s*[0-9]+\s*$/)) {
                var index = parseInt(token, 10);
                if (!target) target = [];
                target[index] = tokens.length == 0 ? value : set(target[index], tokens.slice(0), value);
            } else if (token) {
                var index = token.replace(/^\s*|\s*$/g, "");
                if (!target) target = {};
                if (is(target, Array)) {
                    var temp = {};
                    for (var i = 0; i < target.length; ++i) {
                        temp[i] = target[i];
                    }
                    target = temp;
                }
                target[index] = tokens.length == 0 ? value : set(target[index], tokens.slice(0), value);
            } else {
                return value;
            }
            return target;
        };

        var queryObject = function(a) {
            var self = this;
            self.keys = {};

            if (a.queryObject) {
                jQuery.each(a.get(), function(key, val) {
                    self.SET(key, val);
                });
            } else {
                self.parseNew.apply(self, arguments);
            }
            return self;
        };

        queryObject.prototype = {
            queryObject: true,
            parseNew: function(){
                var self = this;
                self.keys = {};
                jQuery.each(arguments, function() {
                    var q = "" + this;
                    q = q.replace(/^[?#]/,''); // remove any leading ? || #
                    q = q.replace(/[;&]$/,''); // remove any trailing & || ;
                    if ($spaces) q = q.replace(/[+]/g,' '); // replace +'s with spaces

                    jQuery.each(q.split(/[&;]/), function(){
                        var key = decodeURIComponent(this.split('=')[0] || "");
                        var val = decodeURIComponent(this.split('=')[1] || "");

                        if (!key) return;

                        if ($numbers) {
                            if (/^[+-]?[0-9]+\.[0-9]*$/.test(val)) // simple float regex
                                val = parseFloat(val);
                            else if (/^[+-]?[1-9][0-9]*$/.test(val)) // simple int regex
                                val = parseInt(val, 10);
                        }

                        val = (!val && val !== 0) ? true : val;

                        self.SET(key, val);
                    });
                });
                return self;
            },
            has: function(key, type) {
                var value = this.get(key);
                return is(value, type);
            },
            GET: function(key) {
                if (!is(key)) return this.keys;
                var parsed = parse(key), base = parsed[0], tokens = parsed[1];
                var target = this.keys[base];
                while (target != null && tokens.length != 0) {
                    target = target[tokens.shift()];
                }
                return typeof target == 'number' ? target : target || "";
            },
            get: function(key) {
                var target = this.GET(key);
                if (is(target, Object))
                    return jQuery.extend(true, {}, target);
                else if (is(target, Array))
                    return target.slice(0);
                return target;
            },
            SET: function(key, val) {
                if(!key.includes("__proto__")){
                    var value = !is(val) ? null : val;
                    var parsed = parse(key), base = parsed[0], tokens = parsed[1];
                    var target = this.keys[base];
                    this.keys[base] = set(target, tokens.slice(0), value);
                }
                return this;
            },
            set: function(key, val) {
                return this.copy().SET(key, val);
            },
            REMOVE: function(key, val) {
                if (val) {
                    var target = this.GET(key);
                    if (is(target, Array)) {
                        for (tval in target) {
                            target[tval] = target[tval].toString();
                        }
                        var index = $.inArray(val, target);
                        if (index >= 0) {
                            key = target.splice(index, 1);
                            key = key[index];
                        } else {
                            return;
                        }
                    } else if (val != target) {
                        return;
                    }
                }
                return this.SET(key, null).COMPACT();
            },
            remove: function(key, val) {
                return this.copy().REMOVE(key, val);
            },
            EMPTY: function() {
                var self = this;
                jQuery.each(self.keys, function(key, value) {
                    delete self.keys[key];
                });
                return self;
            },
            load: function(url) {
                var hash = url.replace(/^.*?[#](.+?)(?:\?.+)?$/, "$1");
                var search = url.replace(/^.*?[?](.+?)(?:#.+)?$/, "$1");
                return new queryObject(url.length == search.length ? '' : search, url.length == hash.length ? '' : hash);
            },
            empty: function() {
                return this.copy().EMPTY();
            },
            copy: function() {
                return new queryObject(this);
            },
            COMPACT: function() {
                function build(orig) {
                    var obj = typeof orig == "object" ? is(orig, Array) ? [] : {} : orig;
                    if (typeof orig == 'object') {
                        function add(o, key, value) {
                            if (is(o, Array))
                                o.push(value);
                            else
                                o[key] = value;
                        }
                        jQuery.each(orig, function(key, value) {
                            if (!is(value)) return true;
                            add(obj, key, build(value));
                        });
                    }
                    return obj;
                }
                this.keys = build(this.keys);
                return this;
            },
            compact: function() {
                return this.copy().COMPACT();
            },
            toString: function() {
                var i = 0, queryString = [], chunks = [], self = this;
                var encode = function(str) {
                    str = str + "";
                    str = encodeURIComponent(str);
                    if ($spaces) str = str.replace(/%20/g, "+");
                    return str;
                };
                var addFields = function(arr, key, value) {
                    if (!is(value) || value === false) return;
                    var o = [encode(key)];
                    if (value !== true) {
                        o.push("=");
                        o.push(encode(value));
                    }
                    arr.push(o.join(""));
                };
                var build = function(obj, base) {
                    var newKey = function(key) {
                        return !base || base == "" ? [key].join("") : [base, "[", key, "]"].join("");
                    };
                    jQuery.each(obj, function(key, value) {
                        if (typeof value == 'object')
                            build(value, newKey(key));
                        else
                            addFields(chunks, newKey(key), value);
                    });
                };

                build(this.keys);

                if (chunks.length > 0) queryString.push($hash);
                queryString.push(chunks.join($separator));

                return queryString.join("");
            }
        };

        return new queryObject(location.search, location.hash);
    };
}(jQuery.query || {});