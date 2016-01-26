 $(document).ready(function() {
           
		    var tabTitle = $("#tab_title"),
			tabContent = $("#tab_content"),
			tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>",
			tabCounter = 2,
			tabCounter2 = 0,
			tabCountertab = 0;
	    
		    var tabs = $("#tabs").tabs();
	    
		    $(".tabulador").on('click', function(event) {
			    event.preventDefault();
			    var links = $(this).attr('href');
			    var vTITLE = $(this).attr('title');
			    //alert(vTITLE)
			    //alert(tabCounter2+"a");
			    //alert(tabCountertab+"b");
			    if ($("#oculto_tab").val() == 0 && tabCounter2 == 0) {
				    $("#tabu").empty();
				    tabCountertab++;
				    var hola = addTab(links, vTITLE);
				    $("#tabs").tabs("option", "active", Number($("#oculto_tab").val()));
	    
				    //tabCounter2++;
				    //alert("estoyaqui");
				    //alert(tabCounter2);
				    //$("#oculto_tab").val(Number($("#oculto_tab").val())+1);
			    } else if ($("#oculto_tab").val() <= 0 && tabCounter2 > 0 && tabCountertab == 0) {
				    //$("#tabu").empty();
				    var hola = addTab(links, vTITLE);
				    $("#tabs").tabs("option", "active", Number($("#oculto_tab").val()));
				    $("#oculto_tab").val(Number($("#oculto_tab").val()) + 1);
				    tabCounter2 = 0;
				    tabCountertab++;
				    //alert("estyaquidos");
			    } else {
				    //alert($("#oculto_tab").val());
				    var hola = addTab(links, vTITLE);
				    $("#tabs").tabs("option", "active", Number($("#oculto_tab").val()));
				    //alert(tabCounter2);
				    //alert("estoyaqui3");
			    }
			    //$( "#tabs" ).tabs( "option", "active", $("#contador").val() );

	    
		    });
	    
	    
		    //para añadir la super tab
	    
		    function addTab(links, title) {
	    
			    var label = title;//tabTitle.val() || "Tab " + tabCounter,
				id = "tabs-" + tabCounter,
				li = $(tabTemplate.replace(/#\{href\}/g, "#" + id).replace(/#\{label\}/g, label)),
				tabContentHtml = tabContent.val() || "Tab " + tabCounter + " content.";
	    
			    tabs.find(".ui-tabs-nav").append(li);
			    tabs.tabs({ active: 1 });
			    tabs.append("<div id='" + id + "'><iframe id='frame_" + id + "' src='" + links + "' width='100%' height='1600px' scrolling='yes' frameborder='0'></iframe></div>");
			    tabs.tabs("refresh");
	    
			    //tabs("option", "active", tabCounter2);
			    //li.tabs( "select" , id );
			    if ($("#oculto_tab").val() == 1 && tabCounter2 < 1) {
				    tabCounter2++;
			    } else if ($("#oculto_tab").val() == 0 && tabCountertab == 0) {
				    //alert("dondeestoy");
			    } else {
				    //tabCounter2=0;
				    // alert("paseaqui");
				    //alert(tabCountertab);
				    $("#oculto_tab").val(Number($("#oculto_tab").val()) + 1);
			    }
	    
	    
			    tabCounter++;
			    tabCountertab++;
			    //alert(tabCountertab);
			    
			     
			    
			    
			    return id;
	    
		    }
	    
		    // close icon: removing the tab on click
		    tabs.delegate("span.ui-icon-close", "click", function() {
			    var panelId = $(this).closest("li").remove().attr("aria-controls");
			    //alert(panelId);
			    $("#" + panelId).remove();
			    tabs.tabs("refresh");
			    $("#oculto_tab").val(Number($("#oculto_tab").val()) - 1);
			    if ($("#oculto_tab").val() < 0 || $("#oculto_tab").val() == 1 || $("#oculto_tab").val() == 0) {
				    //alert(tabCounter2);
				    tabCounter2++;
				    tabCountertab = 0;
				    //alert(tabCountertab);
				    // alert(tabCountertab=0);
				    // alert(tabCounter2);
			    }
                
                if ($("#oculto_tab").val() < 1){
                    $("#oculto_tab").val(1);
                    tabCounter = 2,
                      tabCounter2 = 0,
                      tabCountertab = 0;
                }
		    });
		    
		    
			    
		    $("#mostrar").on('click', function(event) {
			    
			    alert($("#tabs").tabs("option", "active"));
			    
			    //$("#tabs").tabs("option", "active", $("#contador").val());
			    
			    });
		    $("#activar").on('click', function(event) {
			    
			    
			    
			    $( "#tabs" ).tabs( "option", "active", $("#contador").val() );
			    
			    });
		    
	    });