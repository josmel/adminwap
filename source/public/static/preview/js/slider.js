(function(a) {
    a.flexslider = function(c, b) {
        var d = c;
        d.init = function() {
            d.vars = a.extend({}, a.flexslider.defaults, b);
            d.data("flexslider", true);
            d.container = a(".slides", d);
            d.slides = a(".slides > li", d);
            d.count = d.slides.length;
            d.animating = false;
            d.currentSlide = d.vars.slideToStart;
            d.animatingTo = d.currentSlide;
            d.atEnd = (d.currentSlide == 0) ? true : false;
            d.eventType = ("ontouchstart"in document.documentElement) ? "touchstart" : "click";
            d.cloneCount = 0;
            d.cloneOffset = 0;
            if (d.vars.controlsContainer != "") {
                d.controlsContainer = a(d.vars.controlsContainer).eq(a(".slides").index(d.container));
                d.containerExists = d.controlsContainer.length > 0
            }
            if (d.vars.manualControls != "") {
                d.manualControls = a(d.vars.manualControls, ((d.containerExists) ? d.controlsContainer : d));
                d.manualExists = d.manualControls.length > 0
            }
            if (d.vars.randomize) {
                d.slides.sort(function() {
                    return(Math.round(Math.random()) - 0.5)
                });
                d.container.empty().append(d.slides)
            }
            if (d.vars.animation.toLowerCase() == "slide") {
                d.css({overflow: "hidden"});
                if (d.vars.animationLoop) {
                    d.cloneCount = 2;
                    d.cloneOffset = 1;
                    d.container.append(d.slides.filter(":first").clone().addClass("clone")).prepend(d.slides.filter(":last").clone().addClass("clone"))
                }
                d.container.width(((d.count + d.cloneCount) * d.width()) + 2000);
                d.newSlides = a(".slides > li", d);
                setTimeout(function() {
                    d.newSlides.width(d.width()).css({"float": "left"}).show()
                }, 100);
                d.container.css({marginLeft: (-1 * (d.currentSlide + d.cloneOffset)) * d.width() + "px"})
            } else {
                d.slides.css({width: "100%", "float": "left", marginRight: "-100%"}).eq(d.currentSlide).fadeIn(400)
            }
            if (d.vars.controlNav) {
                if (d.manualExists) {
                    d.controlNav = d.manualControls
                } else {
                    var g = a('<ol class="flex-control-nav"></ol>');
                    var k = 1;
                    for (var l = 0; l < d.count; l++) {
                        g.append("<li><a>" + k + "</a></li>");
                        k++
                    }
                    if (d.containerExists) {
                        a(d.controlsContainer).append(g);
                        d.controlNav = a(".flex-control-nav li a", d.controlsContainer)
                    } else {
                        d.append(g);
                        d.controlNav = a(".flex-control-nav li a", d)
                    }
                }
                d.controlNav.eq(d.currentSlide).addClass("active");
                d.controlNav.bind(d.eventType, function(i) {
                    i.preventDefault();
                    if (!a(this).hasClass("active")) {
                        d.flexAnimate(d.controlNav.index(a(this)), d.vars.pauseOnAction)
                    }
                })
            }

            if (d.vars.slideshow) {
                if (d.vars.pauseOnHover && d.vars.slideshow) {
                    d.hover(function() {
                        d.pause()
                    }, function() {
                        d.resume()
                    })
                }
                d.animatedSlides = setInterval(d.animateSlides, d.vars.slideshowSpeed)
            }

            if (d.vars.touchSwipe && "ontouchstart"in document.documentElement) {
                d.each(function() {
                    var i, j = 20;
                    isMoving = false;
                    function o() {
                        this.removeEventListener("touchmove", m);
                        i = null;
                        isMoving = false
                    }
                    if ("ontouchstart"in document.documentElement) {
                        this.addEventListener("touchstart", n, false)
                    }
                })
            }
            if (d.vars.animation.toLowerCase() == "slide") {
                d.sliderTimer;
                a(window).resize(function() {
                    d.newSlides.width(d.width());
                    d.container.width(((d.count + d.cloneCount) * d.width()) + 2000);
                    clearTimeout(d.sliderTimer);
                    d.sliderTimer = setTimeout(function() {
                        d.flexAnimate(d.currentSlide)
                    }, 300)
                })
            }
            d.vars.start(d)
        };
        d.flexAnimate = function(f, e) {
            if (!d.animating) {
                d.animating = true;
                d.animatingTo = f;
                d.vars.before(d);
                if (e) {
                    d.pause()
                }
                if (d.vars.controlNav) {
                    d.controlNav.removeClass("active").eq(f).addClass("active")
                }
                d.atEnd = (f == 0 || f == d.count - 1) ? true : false;
                if (!d.vars.animationLoop && d.vars.directionNav) {
                    if (f == 0) {
                        d.directionNav.removeClass("disabled").filter(".prev").addClass("disabled")
                    } else {
                        if (f == d.count - 1) {
                            d.directionNav.removeClass("disabled").filter(".next").addClass("disabled")
                        } else {
                            d.directionNav.removeClass("disabled")
                        }
                    }
                }
                if (!d.vars.animationLoop && f == d.count - 1) {
                    d.pause();
                    d.vars.end(d)
                }
                if (d.vars.animation.toLowerCase() == "slide") {
                    if (d.currentSlide == 0 && f == d.count - 1 && d.vars.animationLoop) {
                        d.slideString = "0px"
                    } else {
                        if (d.currentSlide == d.count - 1 && f == 0 && d.vars.animationLoop) {
                            d.slideString = (-1 * (d.count + 1)) * d.slides.filter(":first").width() + "px"
                        } else {
                            d.slideString = (-1 * (f + d.cloneOffset)) * d.slides.filter(":first").width() + "px"
                        }
                    }
                    d.container.animate({marginLeft: d.slideString}, d.vars.animationDuration, function() {
                        if (d.currentSlide == 0 && f == d.count - 1 && d.vars.animationLoop) {
                            d.container.css({marginLeft: (-1 * d.count) * d.slides.filter(":first").width() + "px"})
                        } else {
                            if (d.currentSlide == d.count - 1 && f == 0 && d.vars.animationLoop) {
                                d.container.css({marginLeft: -1 * d.slides.filter(":first").width() + "px"})
                            }
                        }
                        d.animating = false;
                        d.currentSlide = f;
                        d.vars.after(d)
                    })
                } else {
                    d.slides.eq(d.currentSlide).fadeOut(d.vars.animationDuration);
                    d.slides.eq(f).fadeIn(d.vars.animationDuration, function() {
                        d.animating = false;
                        d.currentSlide = f;
                        d.vars.after(d)
                    })
                }
            }
        };
        d.animateSlides = function() {
            if (!d.animating) {
                var e = (d.currentSlide == d.count - 1) ? 0 : d.currentSlide + 1;
                d.flexAnimate(e)
            }
        };

        d.init()
    };
    a.flexslider.defaults = {animation: "fade", slideshow: true, slideshowSpeed: 5000, animationDuration: 600, directionNav: true, controlNav: true, keyboardNav: true, touchSwipe: true, prevText: "Previous", nextText: "Next", pausePlay: false, pauseText: "Pause", playText: "Play", randomize: false, slideToStart: 0, animationLoop: true, pauseOnAction: true, pauseOnHover: false, controlsContainer: "", manualControls: "", start: function() {
        }, before: function() {
        }, after: function() {
        }, end: function() {
        }};
    a.fn.flexslider = function(b) {
        return this.each(function() {
            if (a(this).find(".slides li").length == 1) {
                a(this).find(".slides li").fadeIn(400)
            } else {
                if (a(this).data("flexslider") != true) {
                    new a.flexslider(a(this), b)
                }
            }
        })
    }
})(jQuery);