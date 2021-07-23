function createSearchboxControl() {
    return L.Control.extend({
        _sideBarHeaderTitle: "Sample Title",
        _sideBarMenuItems: {
            Items: [{}],
            _searchfunctionCallBack: function(a) {
                alert("calling the default search call back")
            }
        },
        options: {
            position: "topleft"
        },
        initialize: function(a) {
            L.Util.setOptions(this, a);
            a.sidebarTitleText && (this._sideBarHeaderTitle = a.sidebarTitleText);
            a.sidebarMenuItems && (this._sideBarMenuItems = a.sidebarMenuItems)
        },
        onAdd: function(a) {
            a = L.DomUtil.create("div");
            a.id = "controlcontainer";
            var b = this._sideBarHeaderTitle,
                d = this._sideBarMenuItems,
                c = this._searchfunctionCallBack;
            $(a).html(getControlHrmlContent());
            setTimeout(function() {
                $("#searchbox-searchbutton").click(function() {
                    var a = $("#searchboxinput").val();
                    c(a);
                    $('#searchbox-suggestions-list').empty();
                });

                $("#searchboxinput").keydown(function() {
                    var a = $("#searchboxinput").val();
                    if(realtime == 1) c(a);
                    $('#searchbox-suggestions-list').empty();
                });
                $("#searchbox-menubutton").click(function() {
                    $(".panel").toggle("slide", {
                        direction: "left"
                    }, 500)
                });
                $(".panel-close-button").click(function() {
                    $(".panel").toggle("slide", {
                        direction: "left"
                    }, 500);
                });
                $(".panel-header-title").html(b);
                var a = generateHtmlContent(d);
                $(".panel-content").html(a)
            }, 1);
            L.DomEvent.disableClickPropagation(a);
            return a
        }
    })
};