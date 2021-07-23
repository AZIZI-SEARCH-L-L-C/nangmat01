// start new ---------------------------------------------------------

if(!window.ase_acObj.ase_ac_showOnDocumentClick){window.ase_acObj.ase_ac_showOnDocumentClick="on";}
if(!window.ase_acObj.ase_ac_sig){window.ase_acObj.ase_ac_sig="on";}
if(!window.ase_acObj.ase_ac_user_history){window.ase_acObj.ase_ac_user_history="on";}
if(!window.ase_acObj.ase_ac_sig_html){window.ase_acObj.ase_ac_sig_html='';}
if(!window.ase_acObj.ase_ac_suggestions){window.ase_acObj.ase_ac_suggestions=10;}
if(!window.ase_acObj.ase_ac_l || window.ase_acObj.ase_ac_l=='auto'){
    var userLang = (navigator.language) ? navigator.language : navigator.userLanguage;
    window.ase_acObj.ase_ac_l = userLang.substring(0,2);	// get just the first two chars
}
if(window.ase_acObj.ase_ac_c && window.ase_acObj.ase_ac_c=='auto'){
    window.ase_acObj.ase_ac_c = null;
}
window.ase_acObj.vl = true;

if (!String.prototype.trim) {
    String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g, '');};
}

function ltrim2(str) {
    for(var k = 0; k < str.length && isWhitespace(str.charAt(k)); k++);
    return str.substring(k, str.length);
}

function isWhitespace(charToCheck) {
    var whitespaceChars = " \t\n\r\f";
    return (whitespaceChars.indexOf(charToCheck) != -1);
}

"object"!==typeof JSON&&(JSON={});
(function(){function m(a){return 10>a?"0"+a:a}function r(a){s.lastIndex=0;return s.test(a)?'"'+a.replace(s,function(a){var c=u[a];return"string"===typeof c?c:"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+a+'"'}function p(a,l){var c,d,h,q,g=e,f,b=l[a];b&&("object"===typeof b&&"function"===typeof b.toJSON)&&(b=b.toJSON(a));"function"===typeof k&&(b=k.call(l,a,b));switch(typeof b){case "string":return r(b);case "number":return isFinite(b)?String(b):"null";case "boolean":case "null":return String(b);
    case "object":if(!b)return"null";e+=n;f=[];if("[object Array]"===Object.prototype.toString.apply(b)){q=b.length;for(c=0;c<q;c+=1)f[c]=p(c,b)||"null";h=0===f.length?"[]":e?"[\n"+e+f.join(",\n"+e)+"\n"+g+"]":"["+f.join(",")+"]";e=g;return h}if(k&&"object"===typeof k)for(q=k.length,c=0;c<q;c+=1)"string"===typeof k[c]&&(d=k[c],(h=p(d,b))&&f.push(r(d)+(e?": ":":")+h));else for(d in b)Object.prototype.hasOwnProperty.call(b,d)&&(h=p(d,b))&&f.push(r(d)+(e?": ":":")+h);h=0===f.length?"{}":e?"{\n"+e+f.join(",\n"+
        e)+"\n"+g+"}":"{"+f.join(",")+"}";e=g;return h}}"function"!==typeof Date.prototype.toJSON&&(Date.prototype.toJSON=function(){return isFinite(this.valueOf())?this.getUTCFullYear()+"-"+m(this.getUTCMonth()+1)+"-"+m(this.getUTCDate())+"T"+m(this.getUTCHours())+":"+m(this.getUTCMinutes())+":"+m(this.getUTCSeconds())+"Z":null},String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(){return this.valueOf()});var t=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
    s=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,e,n,u={"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},k;"function"!==typeof JSON.stringify&&(JSON.stringify=function(a,l,c){var d;n=e="";if("number"===typeof c)for(d=0;d<c;d+=1)n+=" ";else"string"===typeof c&&(n=c);if((k=l)&&"function"!==typeof l&&("object"!==typeof l||"number"!==typeof l.length))throw Error("JSON.stringify");return p("",{"":a})});
    "function"!==typeof JSON.parse&&(JSON.parse=function(a,e){function c(a,d){var g,f,b=a[d];if(b&&"object"===typeof b)for(g in b)Object.prototype.hasOwnProperty.call(b,g)&&(f=c(b,g),void 0!==f?b[g]=f:delete b[g]);return e.call(a,d,b)}var d;a=String(a);t.lastIndex=0;t.test(a)&&(a=a.replace(t,function(a){return"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)}));if(/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
        "]").replace(/(?:^|:|,)(?:\s*\[)+/g,"")))return d=eval("("+a+")"),"function"===typeof e?c({"":d},""):d;throw new SyntaxError("JSON.parse");})})();

var profanity_words = null;
function is_profanity(c){
    try{
        if (profanity_words == null)	{
            profanity_words = ["porn","pthc","boob ","jizz","orgy","bdsm","2g1c","a2m ","ass ","bbw ","cum ","tit ","pussy","negro","aryan","bitch","dildo","juggs","yiffy","fuck","titty","pubes","anal ","clit ","cock ","kama ","kike ","milf ","poof ","shit ","slut ","smut ","spic ","twat ","wank ","cunt ","bimbos","goatse","hooker","rectum","sodomy","vagina","goatcx","faggot","rimjob","femdom","dommes","honkey","incest","licked","nympho","tranny","voyeur","spooge","raping","gokkun","blow j","feltch","hentai","sadism","boner ","nigga ","queaf ","twink ","cocks ","twinkie","r@ygold","cocaine","neonazi","strapon","bukkake","jigaboo","asshole","cuckold","redtube","nig nog","camgirl","gay boy","gay sex","humping","schlong","swinger","camslut","raghead","figging","pegging","shemale","kinbaku","shibari","nawashi","fisting","pisspig","bondage","rimming","titties","upskirt","handjob","preteen","footjob","tubgirl","wetback","squirt ","darkie","nigger","orgasm","sleazy d","bunghole","butthole","genitals","taste my","knobbing","huge fat","kinkster","pedobear","swastika","futanari","omorashi","goregasm","clitoris","bisexual","assmunch","daterape","bangbros","camwhore","frotting","tub girl","arsehole","bareback","blumpkin","hand job","birdlock","tentacle","goo girl","ball gag","big tits","bulldyke","ponyplay","mr hands","strap on","piss pig","creampie","jailbait","pre teen","jerk off","babeland","cumming ","dolcett ","gay dog","gay man ","sodomize","prolapsed","big black","dog style","bung hole","fingering","strappado","rosy palm","goodvibes","servitude","two girls","date rape","fapserver","urophilia","anilingus","camel toe","group sex","hard core","threesome","tribadism","dp action","poopchute","zoophilia","phone sex","bastinado","girl on g","throating","gang bang","jail bait","ball sack","fellatio","jack off","jiggaboo","slanteye","stormfront","submissive","black cock","masturbate","eat my ass","bi curious","buttcheeks","circlejerk","autoerotic","giant cock","bestiality","poop chute","muffdiving","scissoring","transexual","asian babe","deepthroat","doggystyle","dominatrix","muff diver","sadie lune","sasha grey","jiggerboo","pedophile","towelhead","violet wand","ejaculation","nsfw images","nimphomania","coprophilia","tea bagging","violet blue","bullet vibe","blue waffle","clusterfuck","doggiestyle","interracial","foot fetish","fudgepacker","spread legs","tongue in a","how to kill","blow your l","deep throat","doggy style","girl on top","nymphomania","style doggy","beaver lips","pole smoker","venus mound","double dong","nonconsent ","paedophile ","sultry women","crossdresser","ball kicking","big knockers","stileproject","motherfucker","spunky teens","fuck buttons","ethical slut","stickam girl","vorarephilia","doggie style","donkey punch","fudge packer","ball licking","ball sucking","shaved pussy","urethra play","raging boner","white power ","cunnilingus ","blonde action","rapping women","dirty sanchez","women rapping","golden shower","piece of shit","dirty pillows","how to murder","carpetmuncher","jackie strano","madison young","shaved beaver","male squirting","yellow showers","acrotomophilia","rusty trombone","linda lovelace","menage a trois","electrotorture","beaver cleaver","carpet muncher","mound of venus","pleasure chest","ducky doolittle","reverse cowgirl","brunette action","barenaked ladies","babes in toyland","bianca beauchamp","wartenberg wheel","courtney trouble","female squirting","one cup two girls","new pornographers","two girls one cup","leather restraint","chocolate rosebuds","double penetration","female desperation","wartenberg pinwheel","missionary position","consensual intercourse","leather straight jacket","blonde on blonde action","rosy palm and her 5 sisters"];
        }
        for(var d=0;d<profanity_words.length;d++){
            if(0<=c.indexOf(profanity_words[d])){	return true;	}
        }
    }	catch (f)	{}
    return false;
}



function addToLocalHistory(latest_sub){
    if(typeof(Storage)=="undefined"){	return;	}
    if(window.ase_acObj.ase_ac_user_history2 && window.ase_acObj.ase_ac_user_history2 != 'on')	{	return;	}
    var ase_ac_user_history2 = localStorage.ase_ac_user_history2;
    if (ase_ac_user_history2 == null)	{
        ase_ac_user_history2 = new Array();
    }	else	{
        ase_ac_user_history2 = JSON.parse(ase_ac_user_history2);
    }
    if (latest_sub != null && latest_sub != "")	{
        var my_term = latest_sub.trim();
        if ( is_profanity(my_term) )	{	return;		}

        var cur_seconds = new Date().getTime() / 1000;	// since 1970...
        var found_it = false;
        for (var i=0;i<ase_ac_user_history2.length;i++)	{
            var item = ase_ac_user_history2[i];
            if (typeof item == "undefined" || item == null || typeof item.term =="undefined" || item.term == null)	{	continue;	}
            if (item.term.toLowerCase() == my_term.toLowerCase())	{
                item.count +=1;
                item.time = cur_seconds;
                found_it = true;
                break;
            }
        }
        if (!found_it)	{
            var newObj 		= new Object();
            newObj.time 	= parseInt(cur_seconds,10);
            newObj.term 	= my_term;
            newObj.count 	= 1;
            ase_ac_user_history2.unshift(newObj);
        }

        localStorage.ase_ac_user_history2 = JSON.stringify( ase_ac_user_history2 )
    }
}

var MAX_LOCAL_OLD_HISTORY_SEC = 60*60*24*30;

function getFromLocaHistory(prefix,max_results,server_res){
    var ret_list = new Array();
    if(typeof Storage=="undefined" || typeof localStorage=="undefined" || typeof JSON=="undefined" ){	return server_res;	}
    var ase_ac_user_history2 = localStorage.ase_ac_user_history2;
    if (ase_ac_user_history2 == null)	{
        ase_ac_user_history2 = new Array();
    }	else	{
        ase_ac_user_history2 = JSON.parse(ase_ac_user_history2);
    }
    if ( ase_ac_user_history2 != null && max_results>=1 )	{
        var cur_seconds = new Date().getTime() / 1000;	// since 1970...
        var prefix = prefix.toLowerCase();

        var changed_history = false;

        var match_loc = -1;
        var cur_term = '';
        for (var i=0;i<ase_ac_user_history2.length;i++)	{
            if (ase_ac_user_history2[i] == null)	{	continue;	}
            if (ase_ac_user_history2[i].term == null || cur_seconds - ase_ac_user_history2[i].time > MAX_LOCAL_OLD_HISTORY_SEC)	{
                // See if this is an old one we should get rid of....
                delete (ase_ac_user_history2[i]);
                changed_history = true;
                continue;
            }
            cur_term  = ase_ac_user_history2[i].term.toLowerCase();

            match_loc = cur_term.indexOf(prefix);
            if ( match_loc==0 || (prefix.length > 2 && match_loc>2 && cur_term[match_loc-1]==" ") )	{
                var newObj = new Object();
                newObj.term = ase_ac_user_history2[i].term;
                newObj.count = ase_ac_user_history2[i].count;
                ret_list.push( newObj );
            }
        }
        if (ret_list.length == 0)	{	return server_res;	}
        // Rank by term popularity...
        ret_list.sort(function(a, b){
            return b.count-a.count;
        })

        // return just the top results...
        ret_list = ret_list.slice(0, max_results);
        var ret_final = new Array();
        for (var i=0;i<ret_list.length;i++)	{
            ret_final.push(ret_list[i].term);
        }
        ret_list = ret_final;
        if (changed_history)	{
            localStorage.ase_ac_user_history2 = JSON.stringify( ase_ac_user_history2 )
        }
    }
    for (var j=0;j<server_res.length;j++)	{
        var found_it = false;
        for (var i=0;i<ret_list.length;i++)	{
            if (server_res[j]==ret_list[i])	{
                found_it = true;
                break;
            }
        }
        if (found_it==false)	{
            ret_list.push(server_res[j]);
        }
    }
    return ret_list;
}
function getInternetExplorerVersion()
// Returns the version of Internet Explorer or a -1
// (indicating the use of another browser).
{
    var docMode = document.documentMode;
    if (docMode ===undefined)	docMode = 9;

    return docMode;

    var rv = 9; // Return value assumes failure.
    if (navigator.appName == 'Microsoft Internet Explorer')
    {
        var ua = navigator.userAgent;
        var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat( RegExp.$1 );
    }
    return rv;
}


function addLoadEvent(func){
    var oldonload=window.onload;if(typeof window.onload!='function'){window.onload=func;}else{window.onload=function(){if(oldonload){oldonload();}
        func();}}
}
if(!window.ase_acObj.ase_ac_vl){window.onpageshow=function(){pushSubmitTerm();};}
function createCookie(name,value,days){
    if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));var expires="; expires="+date.toGMTString();
    }
    else var expires="";document.cookie=name+"="+value+expires+"; path=/";}
function readCookie(name){
    var nameEQ=name+"=";var ca=document.cookie.split(';');for(var i=0;i<ca.length;i++){var c=ca[i];while(c.charAt(0)==' ')c=c.substring(1,c.length);if(c.indexOf(nameEQ)==0)return c.substring(nameEQ.length,c.length);
    }
    return null;}
function eraseCookie(name){
    createCookie(name,"",-1);
}
var cookN='ase_ac_swr_'+window.ase_acObj.ase_ac_partner;
function setToBeCalledParams(){
    var q=document.getElementById(window.ase_acObj.ase_ac_searchbox_id).value; addToLocalHistory(q); var exist=0;if(window.ase_acObj.exist)exist=1;createCookie(cookN,"q="+encodeURIComponent(q)+"&p="+window.ase_acObj.ase_ac_partner+"&e="+exist,2);
}
function pushSubmitTerm(){
    if(window.ase_acObj.vl){return;}
    var params=readCookie(cookN);if(params==null)return;eraseCookie(cookN);var sUrl=window.ase_acObj.ase_ac_api+"/vl?"+params;var s=document.createElement('script');s.setAttribute('type','text/javascript');s.setAttribute('id','stJSON');s.setAttribute('src',sUrl);var oldCall=$$('stJSON');var head=document.getElementsByTagName('head').item(0);if(oldCall)
        oldCall.parentNode.removeChild(oldCall);head.appendChild(s);
}
addLoadEvent(function(){
    var obj=document.getElementById(window.ase_acObj.ase_ac_searchbox_id);
    var ieVer = getInternetExplorerVersion();
    if (ieVer < 8) {
        // IE7 Browser
        obj.onkeyup = function()	{ window.ase_acObj.ac.s(event,this); 			};
        obj.onkeydown = function()	{ window.ase_acObj.ac.s_enter(event, this);	};
        var s = document.createElement('table');
        s.className = 'ase_ac_ltr ase_ac_ltr_ie';
        s.style.display = 'none';
    }	else     {
        // Modern browsers...
        obj.setAttribute("onkeyup","window.ase_acObj.ac.s(event,this);");
        obj.setAttribute("onkeydown","window.ase_acObj.ac.s_enter(event,this);");
        var s = document.createElement('table');
        s.setAttribute('class','ase_ac_ltr');
        s.setAttribute('style','display:none');
    }
    obj.setAttribute('autocomplete','off');
    s.setAttribute('cellspacing','0');
    s.setAttribute('cellpadding','0');
    s.setAttribute('id','suggest');


    var tbody=document.createElement('tbody');tbody.setAttribute('id','suggestions');s.appendChild(tbody);obj.parentNode.appendChild(s);if(window.ase_acObj.ase_ac_sig=="on"){tfoot=document.createElement('tfoot');tr=document.createElement('tr');td=document.createElement('td');td.innerHTML=window.ase_acObj.ase_ac_sig_html;tr.appendChild(td);tfoot.appendChild(tr);s.appendChild(tfoot);}
    setTimeout(function(){pushSubmitTerm();},1111);})
function $$(sId){return document.getElementById(sId);}
var oRequest;(function(){var focus={y:-1,table:$$('suggestions')}

    function focusOn(focus,row){
        for(var i=focus.table.rows.length-1;i>=0;i--)	{
            // Does not work with Quirks Mode... focus.table.rows[i].style.backgroundColor='#ffffff';
            focus.table.rows[i].cells[0].style.backgroundColor='#ffffff';
        }

        if(row===undefined){
            // Does not work with Quirks Mode...  focus.table.rows[focus.y].style.backgroundColor='#D5E2FF';
            focus.table.rows[focus.y].cells[0].style.backgroundColor='#ddd';
            $$(window.ase_acObj.ase_ac_searchbox_id).value=focus.table.rows[focus.y].cells[0].innerHTML.replace(/(<([^>]+)>)/ig,"").replace("&amp;","&");
            var clientType=$$('clientType');
            if(clientType){clientType.value='1';}
        }	else	{
            // Does not work with Quirks Mode...  row.style.backgroundColor='#D5E2FF';
            row.cells[0].style.backgroundColor = '#ddd';
            focus.y=row.getAttribute('sugID');
        }
    }

    function changecss(myclass,element,value){var CSSRules;if(document.all){CSSRules='rules'}else if(document.getElementById){CSSRules='cssRules'}
        var ss=document.styleSheets;for(var i=0;i<document.styleSheets[ss.length-1][CSSRules].length;i++){if(document.styleSheets[ss.length-1][CSSRules][i].selectorText==myclass){document.styleSheets[ss.length-1][CSSRules][i].style[element]=value;return;}}}



    function request(q){if(q.length<1)return;
        var q2 = ltrim2(q)
        if(!focus.table){focus.table=$$('suggestions');var obj=document.getElementById(window.ase_acObj.ase_ac_searchbox_id);}
        // var sUrl=window.ase_acObj.ase_ac_api+"/?n="+window.ase_acObj.ase_ac_suggestions.toString()+"&q="+encodeURIComponent(q2)+"&p="+window.ase_acObj.ase_ac_partner+"&callback=ase_ac_new";if(window.ase_acObj.ase_ac_l){sUrl=sUrl+"&l="+window.ase_acObj.ase_ac_l;}
        var sCountry = '';
        if ( window.ase_acObj.ase_ac_c )	{	sCountry = '&c=' + window.ase_acObj.ase_ac_c.toLowerCase();	}
        var sUrl=window.ase_acObj.ase_ac_api+"?q="+encodeURIComponent(q2) + "&l="+window.ase_acObj.ase_ac_l + sCountry + "&callback=ase_ac_new";
        this.c(sUrl);
    }

    function call(sUrl){var s=document.createElement('script');s.setAttribute('type','text/javascript');s.setAttribute('id','dsJSON');s.setAttribute('src',sUrl);var oldCall=$$('dsJSON');var head=document.getElementsByTagName('head').item(0);if(oldCall)
        oldCall.parentNode.removeChild(oldCall);head.appendChild(s);}

    function suggest_enter(e,q){
        var e=e||event;
        if (e.keyCode == 13)	{
            setToBeCalledParams();
            if(window.ase_acObj.ase_ac_search_form_id)	$$(window.ase_acObj.ase_ac_search_form_id).submit();
            if(window.ase_acObj.ase_ac_search_form_name)	document.forms[window.ase_acObj.ase_ac_search_form_name].submit();
        }
        // Tab - copy the first suggestion up top
        if (e.keyCode ==9 && focus.y >=0 && focus.table)	{
            if (focus.table.rows.length > 0)	{
                $$(window.ase_acObj.ase_ac_searchbox_id).value = focus.table.rows[focus.y].cells[0].innerHTML.replace(/(<([^>]+)>)/ig,"").replace("&amp;","&");
            }
            if(e.preventDefault) {
                e.preventDefault();
            }
            return false;
        }
    }

    function suggest(e,q){
        var clientType=$$('clientType');if(clientType){clientType.value='0';}
        if(q.value.length==0){$$('suggest').style.display='none';return};
        var e=e||event;
        switch(e.keyCode){
            case 38:focus.y--;window.ase_acObj.exist=true;break;
            case 40:focus.y++;window.ase_acObj.exist=true;break;
            case 13:case 39:case 37: $$('suggest').style.display = 'none';	return;break;
            // Esc key - Hide suggest box
            case 27:$$('suggest').style.display = 'none';return;

            default:window.ase_acObj.exist=false;this.r(q.value);focus.y=-1;return;
        }

        if (focus.table)	{
            if(focus.y<0)			{	focus.y=focus.table.rows.length-1;	}
            if(focus.y>=focus.table.rows.length)	{	focus.y=0;	}
            if(focus.y>=focus.table.rows.length)	{	focus.y=0;	}
            this.f(focus);
        }
    }

    function draw(str){ var tbody=$$('suggestions');
        if( str.query!=ltrim2($$(window.ase_acObj.ase_ac_searchbox_id).value.toLowerCase()) ){return;}
        str.items = getFromLocaHistory(str.query,3, str.items );
        var suggest 	=	String(str.items).split(',');
        suggest 		= 	suggest.slice(0, parseInt( window.ase_acObj.ase_ac_suggestions,0 ))
        while(tbody.rows&&tbody.rows.length)tbody.deleteRow(-1);
        for(s in suggest){
            if(suggest[s]=='')continue;
            var row=tbody.insertRow(-1);
            var cell=row.insertCell(0);
            if(str.query==suggest[s].substr(0,str.query.length)){var data=str.query+'<b>'+suggest[s].substr(str.query.length,suggest[s].length)+'</b>';}else{var data='<b>'+suggest[s]+'</b>';}
            cell.innerHTML=data;cell.style.width='';
            row.setAttribute('sugID',s)
            row.onmouseover=function(){window.ase_acObj.ac.f(focus,this)};
            row.onclick=function(){
                $$('suggest').style.display = 'none'

                $$(window.ase_acObj.ase_ac_searchbox_id).value=this.cells[0].innerHTML.replace(/(<([^>]+)>)/ig,"").replace("&amp;","&");var clientType=$$('clientType');if(clientType){clientType.value='1';		}
                window.ase_acObj.exist=true;
                setToBeCalledParams();
                if(window.ase_acObj.ase_ac_search_form_id)$$(window.ase_acObj.ase_ac_search_form_id).submit();
                if(window.ase_acObj.ase_ac_search_form_name)document.forms[window.ase_acObj.ase_ac_search_form_name].submit();
            }
            ;}

        if($$('suggest').style.display=='none')
            $$('suggest').style.display='block';


        if(tbody.rows.length==0)$$('suggest').style.display='none';

        if (window.ase_acObj.ase_ac_showOnDocumentClick!="on"){	document.onclick=function(e){$$('suggest').style.display='none'} }

    }
    window.ase_acObj.ac={s:suggest,s_enter:suggest_enter,h:draw,r:request,c:call,f:focusOn,css:changecss};})();function ase_ac_new(str){window.ase_acObj.ac.h(str);}