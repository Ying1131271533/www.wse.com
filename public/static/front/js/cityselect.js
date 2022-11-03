/* *
 * 全局空间 Vcity
 * */
var Vcity = {};
/* *
 * 静态方法集
 * @name _m
 * */
Vcity._m = {
    /* 选择元素 */
    $:function (arg, context) {
        var tagAll, n, eles = [], i, sub = arg.substring(1);
        context = context || document;
        if (typeof arg == 'string') {
            switch (arg.charAt(0)) {
                case '#':
                    return document.getElementById(sub);
                    break;
                case '.':
                    if (context.getElementsByClassName) return context.getElementsByClassName(sub);
                    tagAll = Vcity._m.$('*', context);
                    n = tagAll.length;
                    for (i = 0; i < n; i++) {
                        if (tagAll[i].className.indexOf(sub) > -1) eles.push(tagAll[i]);
                    }
                    return eles;
                    break;
                default:
                    return context.getElementsByTagName(arg);
                    break;
            }
        }
    },

    /* 绑定事件 */
    on:function (node, type, handler) {
        node.addEventListener ? node.addEventListener(type, handler, false) : node.attachEvent('on' + type, handler);
    },

    /* 获取事件 */
    getEvent:function(event){
        return event || window.event;
    },

    /* 获取事件目标 */
    getTarget:function(event){
        return event.target || event.srcElement;
    },

    /* 获取元素位置 */
    getPos:function (node) {
        var scrollx = document.documentElement.scrollLeft || document.body.scrollLeft,
                scrollt = document.documentElement.scrollTop || document.body.scrollTop;
        var pos = node.getBoundingClientRect();
        return {top:pos.top + scrollt, right:pos.right + scrollx, bottom:pos.bottom + scrollt, left:pos.left + scrollx }
    },

    /* 添加样式名 */
    addClass:function (c, node) {
        if(!node)return;
        node.className = Vcity._m.hasClass(c,node) ? node.className : node.className + ' ' + c ;
    },

    /* 移除样式名 */
    removeClass:function (c, node) {
        var reg = new RegExp("(^|\\s+)" + c + "(\\s+|$)", "g");
        if(!Vcity._m.hasClass(c,node))return;
        node.className = reg.test(node.className) ? node.className.replace(reg, '') : node.className;
    },

    /* 是否含有CLASS */
    hasClass:function (c, node) {
        if(!node || !node.className)return false;
        return node.className.indexOf(c)>-1;
    },

    /* 阻止冒泡 */
    stopPropagation:function (event) {
        event = event || window.event;
        event.stopPropagation ? event.stopPropagation() : event.cancelBubble = true;
    },
    /* 去除两端空格 */
    trim:function (str) {
        return str.replace(/^\s+|\s+$/g,'');
    }
};

/* 所有城市数据,可以按照格式自行添加（北京|beijing|bj），前16条为热门城市 */

Vcity.allCity = ['美国|UNITEDSTATES|US','中国|CHINA|CN','俄罗斯|RUSSIANFEDERATION|RU','英国|UNITEDKINGDOM|GB','德国|Germany|DE','法国|France|FR','加拿大|Canada|CA','巴西|Brazil|BR','澳大利亚|Australia|AU','荷兰|NETHERLANDS|NL','意大利|Italy|IT','西班牙|Spain|ES','日本|Japan|JP','印度|India|IN','阿尔巴尼亚|Albania|AL','阿尔及利亚|Algeria|DZ','阿富汗|Afghanistan|AF','阿根廷|Argentina|AR','阿联酋|UnitedArabEmirates|AE','阿鲁巴|Aruba|AW','阿曼|Oman|OM','阿塞拜疆|Azerbaijan|AZ','阿森松|ASCENSION|XD','埃及|Egypt|EG','埃塞俄比亚|ETHIOPIA|ET','爱尔兰|IRELAND|IE','爱沙尼亚|Estonia|EE','安道尔|ANDORRA|AD','安哥拉|Angola|AO','安圭拉|Anguilla|AI','安提瓜|ANTIGUAANDBARBUDA|AG','奥地利|AUSTRIA|AT','奥兰群岛|Ahvenanmaa|AX','澳大利亚|Australia|AU','澳门|Macau|MO','巴巴多斯|Barbados|BB','巴布亚新几内亚|PapuaNewGuinea|PG','巴哈马|BAHAMAS|BS','巴基斯坦|Pakistan|PK','巴拉圭|Paraguay|PY','巴勒斯坦|PALESTINE|PS','巴利阿里群岛|BALEARICISLANDS|XJ','巴林|Bahrain|BH','巴拿马|Panama|PA','巴西|Brazil|BR','白俄罗斯|Belarus|BY','百慕大|Bermuda|BM','保加利亚|Bulgaria|BG','北非西班牙属土|SPANISHTERRITORIESOFNAFRICA|XG','贝宁|Benin|BJ','比利时|BELGIUM|BE','冰岛|Iceland|IS','波多黎各|PuertoRico|PR','波兰|POLAND|PL','波斯尼亚黑塞哥维那共和国|BOSNIAANDHERZEGOVINA|BA','玻利维亚|BOLIVIA|BO','伯利兹|Belize|BZ','伯奈尔岛|BONAIRE|XB','博茨瓦纳|Botswana|BW','不丹|Bhutan|BT','布基纳法索|BurkinaFaso|BF','布隆迪|Burundi|BI','布维岛|BOUVETISLAND|BV','朝鲜|NORTHKOREA|KP','赤道几内亚|EquatorialGuinea|GQ','丹麦|Denmark|DK','德国|Germany|DE','东帝汶|EASTTIMOR|TL','多哥|Togo|TG','多米尼加|Dominica|DM','多米尼加共和国|DominicanRepublic|DO','俄罗斯|RUSSIANFEDERATION|RU','厄瓜多尔|Ecuador|EC','厄立特里亚|Eritrea|ER','法国|France|FR','法罗群岛|FaroeIslands|FO','法属波利尼西亚|FRENCHPOLYNESIA|PF','法属圭亚那|FrenchGuiana|GF','法属美特罗波利坦|FRANCEMETROPOLITAN|FX','法属南部领土|FRENCHSOUTHERNTERRITORIES|TF','梵蒂冈|VATICANCITY|VA','菲律宾|Philippines|PH','斐济群岛|FijiIslands|FJ','芬兰|Finland|FI','佛得角群岛|CAPEVERDE|CV','福克兰群岛|FalklandIslands|FK','冈比亚|Gambia|GM','刚果|CONGO|CG','刚果民主共和国|CONGOREPUBLIC|CD','哥伦比亚|Colombia|CO','哥斯达黎加|COSTARICA|CR','格林纳达|Grenada|GD','格陵兰岛|Greenland|GL','格鲁吉亚|Georgia|GE','根西岛|GUERNSEY|GG','古巴|CUBA|CU','瓜德罗普|Guadeloupe|GP','关岛|Guam|GU','圭亚那|GuyanaBritish|GY','哈萨克斯坦|Kazakhstan|KZ','海地|Haiti|HT','韩国|Korea|KR','荷兰|NETHERLANDS|NL','荷属安的列斯群岛|NETHERLANDSANTILLES|AN','赫德岛和麦克唐纳岛|HEARDISLANDANDMCDONALDISLANDS|HM','黑山共和国|MONTENEGRO|ME','洪都拉斯|Honduras|HN','基里巴斯|Kiribati|KI','吉布提|Djibouti|DJ','吉尔吉斯斯坦|Kyrgyzstan|KG','几内亚|Guinea|GN','几内亚比绍|GUINEABISSAU|GW','加罗林群岛|CAROLINEISLANDS|XK','加拿大|Canada|CA','加那利群岛|CANARYISLANDS|IC','加纳|Ghana|GH','加蓬|Gabon|GA','柬埔寨|Cambodia|KH','捷克共和国|CzechRepublic|CZ','津巴布韦|Zimbabwe|ZW','喀麦隆|Cameroon|CM','卡塔尔|Qatar|QA','开曼群岛|CaymanIslands|KY','科科斯群岛|COCOSKEELINGISLANDS|CC','科摩罗|Comoros|KM','科索沃|KOSOVO|KV','科特迪瓦象牙海岸|COTEDLVOIREIVORY|CI','科威特|Kuwait|KW','克罗地亚|Croatia|HR','肯尼亚|Kenya|KE','库克群岛|CookIslands|CK','库拉索岛荷兰|CURACAO|XC','拉脱维亚|Latvia|LV','莱索托|Lesotho|LS','老挝|Laos|LA','黎巴嫩|Lebanon|LB','立陶宛|Lithuania|LT','利比里亚|Liberia|LR','利比亚|Libya|LY','列支敦士登|Liechtenstein|LI','留尼汪岛|Reunion|RE','卢森堡|Luxembourg|LU','卢旺达|Rwanda|RW','罗马尼亚|Romania|RO','马达加斯加|Madagascar|MG','马德拉岛|MADEIRA|XI','马恩岛|IsleofMan|IM','马尔代夫|Maldives|MV','马耳他|MALTA|MT','马拉维|Malawi|MW','马来西亚|MALAYSIA|MY','马里|MALI|ML','马其顿|Macedonia|MK','马绍尔群岛|RepublicofMarshallIslands|MH','马提尼克岛|MARTINIQUE|MQ','马约特|MAYOTTE|YT','毛里求斯|Mauritius|MU','毛里塔尼亚|Mauritania|MR','美国|UNITEDSTATES|US','美属萨摩亚群岛|AMERICANSAMOA|AS','美属维尔京群岛|VirginIslandsUS|VI','蒙古|Mongolia|MN','蒙特塞拉岛|MONTSERRAT|MS','孟加拉|Bangladesh|BD','秘鲁|Peru|PE','密克罗尼西亚|MICRONESIA|FM','缅甸|Myanmar|MM','摩尔多瓦|MOLDOVAREPUBLICOF|MD','摩洛哥|Morocco|MA','摩纳哥|MONACO|MC','莫桑比克|Mozambique|MZ','墨西哥|Mexico|MX','纳米比亚|Namibia|NA','南非|SouthAfrica|ZA','南乔治亚岛和南桑威奇群岛|SOUTHGEORGIAANDTHESOUTHSANDWICHISL|GS','南斯拉夫|YUGOSLAVIA|JU','南苏丹共和国|SOUTHSUDAN|SS','瑙鲁|NauruRepublicof|NR','尼泊尔|Nepal|NP','尼加拉瓜|Nicaragua|NI','尼日尔|Niger|NE','尼日利亚|Nigeria|NG','尼维斯岛|NEVIS|XN','纽埃岛|Niue|NU','挪威|Norway|NO','诺福克岛|nuofukedao|NF','帕劳|PALAU|PW','皮特凯恩群岛|PITCAIRNISLANDS|PN','葡萄牙|Portugal|PT','日本|Japan|JP','瑞典|SWEDEN|SE','瑞士|Switzerland|CH','萨尔瓦多|ElSalvador|SV','塞班岛|SAIPAN|MP','塞尔维亚|SERBIAREPUBLICOF|RS','塞拉利昂|SierraLeone|SL','塞内加尔|Senegal|SN','塞浦路斯|Cyprus|CY','塞舌尔|Seychelles|SC','沙特阿拉伯|SAUDIARABIA|SA','圣巴特勒米岛|STBARTHELEMY|XY','圣诞岛|CHRISTMASISLAND|CX','圣多美和普林西比|SAOTOMEANDPRINCIPE|ST','圣赫勒拿岛|STHELENA|SH','圣基茨|SAINTKITTS|KN','圣卢西亚岛|StLucia|LC','圣马力诺|SANMARINO|SM','圣马腾岛|STMAARTEN|XM','圣皮埃尔和密克隆群岛|SAINTPIERREANDMIQUELON|PM','圣文森特岛|StVincent|VC','圣尤斯塔提马斯岛|STEUSTATIUS|XE','斯里兰卡|SriLanka|LK','斯洛伐克|SLOVAKIAREPUBLIC|SK','斯洛文尼亚|Slovenia|SI','斯瓦尔巴岛和扬马延岛|SVALBARDANDJANMAYEN|SJ','斯威士兰|Swaziland|SZ','苏丹|Sudan|SD','苏里南|Suriname|SR','所罗门群岛|SOLOMONISLANDS|SB','索马里共和国|Somalia|XS','索马里兰|Somaliland|SO','塔吉克斯坦|Tajikistan|TJ','台湾|Taiwan|TW','泰国|THAILAND|TH','坦桑尼亚|Tanzania|TZ','汤加|Tonga|TO','特克斯和凯科斯群岛|TurksAndCaicosIslands|TC','特里斯坦|TRISTANDACUNBA|TA','特立尼达和多巴哥|TrinidadandTobago|TT','突尼斯|Tunisia|TN','图瓦卢|Tuvalu|TV','土耳其|Turkey|TR','土库曼斯坦|Turkmenistan|TM','托克劳|TOKELAU|TK','瓦利斯群岛和富图纳群岛|WALLISANDFUTUNAISLANDS|WF','瓦努阿图|Vanuatu|VU','危地马拉|Guatemala|GT','委内瑞拉|Venezuela|VE','文莱|BRUNEI|BN','乌干达|Uganda|UG','乌克兰|UKRAINE|UA','乌拉圭|Uruguay|UY','乌兹别克斯坦|Uzbekistan|UZ','西班牙|Spain|ES','西撒哈拉|WESTERNSAHARA|EH','西萨摩亚|WESTERNSAMOA|WS','希腊|Greece|GR','香港|Hongkong|HK','新加坡|Singapore|SG','新喀里多尼亚|NewCaledonia|NC','新西兰|NewZealand|NZ','匈牙利|Hungary|HU','叙利亚|Syria|SY','牙买加|Jamaica|JM','亚美尼亚|Armenia|AM','亚速尔群岛|AZORES|XH','也门|Yemen|YE','伊拉克|Iraq|IQ','伊朗|Iran|IR','以色列|Israel|IL','意大利|Italy|IT','印度|India|IN','印度尼西亚|Indonesia|ID','英国|UNITEDKINGDOM|GB','英属维尔京群岛|VIRGINISLAND|VG','英属印度洋地区查各群岛|BRITISHINDIANOCEANTERRITORY|IO','约旦|Jordan|JO','越南|VIETNAM|VN','赞比亚|Zambia|ZM','泽西岛|Jersey|JE','扎伊尔|ZAIRE|ZR','乍得|Chad|TD','直布罗陀|Gibraltar|GI','智利|Chile|CL','中非共和国|CentralAfricanRepublic|CF','中国|CHINA|CN'];


/* 正则表达式 筛选中文城市名、拼音、首字母 */

Vcity.regEx = /^([\u4E00-\u9FA5\uf900-\ufa2d]+)\|(\w+)\|(\w)\w*$/i;
Vcity.regExChiese = /([\u4E00-\u9FA5\uf900-\ufa2d]+)/;

/* *
 * 格式化城市数组为对象oCity，按照a-h,i-p,q-z,hot热门城市分组：
 * {HOT:{hot:[]},ABCDEFGH:{a:[1,2,3],b:[1,2,3]},IJKLMNOP:{i:[1.2.3],j:[1,2,3]},QRSTUVWXYZ:{}}
 * */
(function () {
    var citys = Vcity.allCity, match, letter,
            regEx = Vcity.regEx,
            reg2 = /^[a-b]$/i, reg3 = /^[c-d]$/i, reg4 = /^[e-g]$/i,reg5 = /^[h]$/i,reg6 = /^[j]$/i,reg7 = /^[k-l]$/i,reg8 =  /^[m-p]$/i,reg9 =  /^[q-r]$/i,reg10 =  /^[s]$/i,reg11 =  /^[t]$/i,reg12 =  /^[w]$/i,reg13 =  /^[x]$/i,reg14 =  /^[y]$/i,reg15 =  /^[z]$/i;
    if (!Vcity.oCity) {
        Vcity.oCity = {hot:{},AB:{},CD:{},EFG:{},H:{},J:{},KL:{},MNP:{},QR:{},S:{},T:{},W:{},X:{},Y:{},Z:{}};
        //console.log(citys.length);
        for (var i = 0, n = citys.length; i < n; i++) {
            match = regEx.exec(citys[i]);
            letter = match[3].toUpperCase();
            if (reg2.test(letter)) {
                if (!Vcity.oCity.AB[letter]) Vcity.oCity.AB[letter] = [];
                Vcity.oCity.AB[letter].push(match[1]);
            } else if (reg3.test(letter)) {
                if (!Vcity.oCity.CD[letter]) Vcity.oCity.CD[letter] = [];
                Vcity.oCity.CD[letter].push(match[1]);
            } else if (reg4.test(letter)) {
                if (!Vcity.oCity.EFG[letter]) Vcity.oCity.EFG[letter] = [];
                Vcity.oCity.EFG[letter].push(match[1]);
            }else if (reg5.test(letter)) {
                if (!Vcity.oCity.H[letter]) Vcity.oCity.H[letter] = [];
                Vcity.oCity.H[letter].push(match[1]);
            }else if (reg6.test(letter)) {
                if (!Vcity.oCity.J[letter]) Vcity.oCity.J[letter] = [];
                Vcity.oCity.J[letter].push(match[1]);
            }else if (reg7.test(letter)) {
                if (!Vcity.oCity.KL[letter]) Vcity.oCity.KL[letter] = [];
                Vcity.oCity.KL[letter].push(match[1]);
            }else if (reg8.test(letter)) {
                if (!Vcity.oCity.MNP[letter]) Vcity.oCity.MNP[letter] = [];
                Vcity.oCity.MNP[letter].push(match[1]);
            }else if (reg9.test(letter)) {
                if (!Vcity.oCity.QR[letter]) Vcity.oCity.QR[letter] = [];
                Vcity.oCity.QR[letter].push(match[1]);
            }else if (reg10.test(letter)) {
                if (!Vcity.oCity.S[letter]) Vcity.oCity.S[letter] = [];
                Vcity.oCity.S[letter].push(match[1]);
            }else if (reg11.test(letter)) {
                if (!Vcity.oCity.T[letter]) Vcity.oCity.T[letter] = [];
                Vcity.oCity.T[letter].push(match[1]);
            }else if (reg12.test(letter)) {
                if (!Vcity.oCity.W[letter]) Vcity.oCity.W[letter] = [];
                Vcity.oCity.W[letter].push(match[1]);
            }else if (reg13.test(letter)) {
                if (!Vcity.oCity.X[letter]) Vcity.oCity.X[letter] = [];
                Vcity.oCity.X[letter].push(match[1]);
            }else if (reg14.test(letter)) {
                if (!Vcity.oCity.Y[letter]) Vcity.oCity.Y[letter] = [];
                Vcity.oCity.Y[letter].push(match[1]);
            }else if (reg15.test(letter)) {
                if (!Vcity.oCity.Z[letter]) Vcity.oCity.Z[letter] = [];
                Vcity.oCity.Z[letter].push(match[1]);
            }

            /* 热门城市 前16条 */
            if(i<14){
                if(!Vcity.oCity.hot['hot']) Vcity.oCity.hot['hot'] = [];
                Vcity.oCity.hot['hot'].push(match[1]);
            }
        }
    }
})();


/* 城市HTML模 */
Vcity._template = [
    '<p class="tip">直接输入可搜索城市(支持汉字/二字简码)根据二字码排序</p>',
    '<ul>',
    '<li class="on">热门城市</li>',
    '<li>AB</li>',
    '<li>CD</li>',
    '<li>EFG</li>',
    '<li>H</li>',
    '<li>J</li>',
    '<li>KL</li>',
    '<li>MNP</li>',
    '<li>QR</li>',
    '<li>S</li>',
    '<li>T</li>',
    '<li>W</li>',
    '<li>X</li>',
    '<li>Y</li>',
    '<li>Z</li>',
    '</ul>'
];

/* *
 * 城市控件构造函数
 * @CitySelector
 * */

Vcity.CitySelector = function () {
    this.initialize.apply(this, arguments);
};

Vcity.CitySelector.prototype = {

    constructor:Vcity.CitySelector,

    /* 初始化 */

    initialize :function (options) {
        var input = options.input;
        this.input = Vcity._m.$('#'+ input);
        this.inputEvent();
    },

    /* *
        

    /* *
     * @createWarp
     * 创建城市BOX HTML 框架
     * */

    createWarp:function(){
        var inputPos = Vcity._m.getPos(this.input);
        var div = this.rootDiv = document.createElement('div');
        var that = this;

        // 设置DIV阻止冒泡
        Vcity._m.on(this.rootDiv,'click',function(event){
            Vcity._m.stopPropagation(event);
        });

        // 设置点击文档隐藏弹出的城市选择框
        Vcity._m.on(document, 'click', function (event) {
            event = Vcity._m.getEvent(event);
            var target = Vcity._m.getTarget(event);
            if(target == that.input) return false;
            //console.log(target.className);
            if (that.cityBox)Vcity._m.addClass('hide', that.cityBox);
            if (that.ul)Vcity._m.addClass('hide', that.ul);
            if(that.myIframe)Vcity._m.addClass('hide',that.myIframe);
        });
        div.className = 'citySelector';
        div.style.position = 'absolute';
        div.style.left = inputPos.left + 'px';
        div.style.top = inputPos.bottom + 5 + 'px';
        div.style.zIndex = 999999;

        // 判断是否IE6，如果是IE6需要添加iframe才能遮住SELECT框
        var isIe = (document.all) ? true : false;
        var isIE6 = this.isIE6 = isIe && !window.XMLHttpRequest;
        if(isIE6){
            var myIframe = this.myIframe =  document.createElement('iframe');
            myIframe.frameborder = '0';
            myIframe.src = 'about:blank';
            myIframe.style.position = 'absolute';
            myIframe.style.zIndex = '-1';
            this.rootDiv.appendChild(this.myIframe);
        }

        var childdiv = this.cityBox = document.createElement('div');
        childdiv.className = 'cityBox';
        childdiv.id = 'cityBox';
        childdiv.innerHTML = Vcity._template.join('');
        var hotCity = this.hotCity =  document.createElement('div');
        hotCity.className = 'hotCity';
        childdiv.appendChild(hotCity);
        div.appendChild(childdiv);
        this.createHotCity();
    },

    /* *
     * @createHotCity
     * TAB下面DIV：hot,a-h,i-p,q-z 分类HTML生成，DOM操作
     * {HOT:{hot:[]},ABCDEFGH:{a:[1,2,3],b:[1,2,3]},IJKLMNOP:{},QRSTUVWXYZ:{}}
     **/

    createHotCity:function(){
        var odiv,odl,odt,odd,odda=[],str,key,ckey,sortKey,regEx = Vcity.regEx,
                oCity = Vcity.oCity;
        for(key in oCity){
            odiv = this[key] = document.createElement('div');
            // 先设置全部隐藏hide
            odiv.className = key + ' ' + 'cityTab hide';
            sortKey=[];
            for(ckey in oCity[key]){
                sortKey.push(ckey);
                // ckey按照ABCDEDG顺序排序
                sortKey.sort();
            }
            for(var j=0,k = sortKey.length;j<k;j++){
                odl = document.createElement('dl');
                odt = document.createElement('dt');
                odd = document.createElement('dd');
                odt.innerHTML = sortKey[j] == 'hot'?'&nbsp;':sortKey[j];
                odda = [];
                for(var i=0,n=oCity[key][sortKey[j]].length;i<n;i++){
                    str = '<a href="#">' + oCity[key][sortKey[j]][i] + '</a>';
                    odda.push(str);
                }
                odd.innerHTML = odda.join('');
                odl.appendChild(odt);
                odl.appendChild(odd);
                odiv.appendChild(odl);
            }

            // 移除热门城市的隐藏CSS
            Vcity._m.removeClass('hide',this.hot);
            this.hotCity.appendChild(odiv);
        }
        document.body.appendChild(this.rootDiv);
        /* IE6 */
        this.changeIframe();

        this.tabChange();
        this.linkEvent();
    },

    /* *
     *  tab按字母顺序切换
     *  @ tabChange
     * */

    tabChange:function(){
        var lis = Vcity._m.$('li',this.cityBox);
        var divs = Vcity._m.$('div',this.hotCity);
        var that = this;
        for(var i=0,n=lis.length;i<n;i++){
            lis[i].index = i;
            lis[i].onclick = function(){
                for(var j=0;j<n;j++){
                    Vcity._m.removeClass('on',lis[j]);
                    Vcity._m.addClass('hide',divs[j]);
                }
                Vcity._m.addClass('on',this);
                Vcity._m.removeClass('hide',divs[this.index]);
                /* IE6 改变TAB的时候 改变Iframe 大小*/
                that.changeIframe();
            };
        }
    },

    /* *
     * 城市LINK事件
     *  @linkEvent
     * */

    linkEvent:function(){
        var links = Vcity._m.$('a',this.hotCity);
        var that = this;
        for(var i=0,n=links.length;i<n;i++){
            links[i].onclick = function(){
                that.input.value = this.innerHTML;
                Vcity._m.addClass('hide',that.cityBox);
                /* 点击城市名的时候隐藏myIframe */
                Vcity._m.addClass('hide',that.myIframe);
            }
        }
    },

    /* *
     * INPUT城市输入框事件
     * @inputEvent
     * */

    inputEvent:function(){
        var that = this;
        Vcity._m.on(this.input,'click',function(event){
            event = event || window.event;
            if(!that.cityBox){
                that.createWarp();
            }else if(!!that.cityBox && Vcity._m.hasClass('hide',that.cityBox)){
                // slideul 不存在或者 slideul存在但是是隐藏的时候 两者不能共存
                if(!that.ul || (that.ul && Vcity._m.hasClass('hide',that.ul))){
                    Vcity._m.removeClass('hide',that.cityBox);

                    /* IE6 移除iframe 的hide 样式 */
                    //alert('click');
                    Vcity._m.removeClass('hide',that.myIframe);
                    that.changeIframe();
                }
            }
        });
        // Vcity._m.on(this.input,'focus',function(){
        //     that.input.select();
        //     if(that.input.value == '城市名') that.input.value = '';
        // });
        Vcity._m.on(this.input,'blur',function(){
            // if(that.input.value == '') that.input.value = '城市名';
            
            var value = Vcity._m.trim(that.input.value);
            if(value != ''){
                var reg = new RegExp("^" + value + "|\\|" + value, 'gi');
                var flag=0;
                for (var i = 0, n = Vcity.allCity.length; i < n; i++) {
                    if (reg.test(Vcity.allCity[i])) {
                        flag++;
                    }
                }
                if(flag==0){
                    that.input.value= '';
                }else{
                    var lis = Vcity._m.$('li',that.ul);
                    if(typeof lis == 'object' && lis['length'] > 0){
                        var li = lis[0];
                        var bs = li.children;
                        if(bs && bs['length'] > 1){
                            that.input.value = bs[0].innerHTML;
                        }
                    }else{
                        that.input.value = '';
                    }
                }
            }

        });
        Vcity._m.on(this.input,'keyup',function(event){
            event = event || window.event;
            var keycode = event.keyCode;
            Vcity._m.addClass('hide',that.cityBox);
            that.createUl();

            /* 移除iframe 的hide 样式 */
            Vcity._m.removeClass('hide',that.myIframe);

            // 下拉菜单显示的时候捕捉按键事件
            if(that.ul && !Vcity._m.hasClass('hide',that.ul) && !that.isEmpty){
                that.KeyboardEvent(event,keycode);
            }
        });
    },

    /* *
     * 生成下拉选择列表
     * @ createUl
     * */

    createUl:function () {
        //console.log('createUL');
        var str;
        var value = Vcity._m.trim(this.input.value);
        // 当value不等于空的时候执行
        if (value !== '') {
            var reg = new RegExp("^" + value + "|\\|" + value, 'gi');
            // 此处需设置中文输入法也可用onpropertychange
            var searchResult = [];
            for (var i = 0, n = Vcity.allCity.length; i < n; i++) {
                if (reg.test(Vcity.allCity[i])) {
                    var match = Vcity.regEx.exec(Vcity.allCity[i]);
                    if (searchResult.length !== 0) {
                        str = '<li><b class="cityname">' + match[1] + '</b><b class="cityspell">' + match[2] + '</b></li>';
                    } else {
                        str = '<li class="on"><b class="cityname">' + match[1] + '</b><b class="cityspell">' + match[2] + '</b></li>';
                    }
                    searchResult.push(str);
                }
            }
            this.isEmpty = false;
            // 如果搜索数据为空
            if (searchResult.length == 0) {
                this.isEmpty = true;
                str = '<li class="empty">对不起，没有找到 "<em>' + value + '</em>"</li>';
                searchResult.push(str);
            }
            // 如果slideul不存在则添加ul
            if (!this.ul) {
                var ul = this.ul = document.createElement('ul');
                ul.className = 'cityslide mCustomScrollbar';
                this.rootDiv && this.rootDiv.appendChild(ul);
                // 记录按键次数，方向键
                this.count = 0;
            } else if (this.ul && Vcity._m.hasClass('hide', this.ul)) {
                this.count = 0;
                Vcity._m.removeClass('hide', this.ul);
            }
            this.ul.innerHTML = searchResult.join('');

            /* IE6 */
            this.changeIframe();

            // 绑定Li事件
            this.liEvent();
        }else{
            Vcity._m.addClass('hide',this.ul);
            Vcity._m.removeClass('hide',this.cityBox);

            Vcity._m.removeClass('hide',this.myIframe);

            this.changeIframe();
        }
    },

    /* IE6的改变遮罩SELECT 的 IFRAME尺寸大小 */
    changeIframe:function(){
        if(!this.isIE6)return;
        this.myIframe.style.width = this.rootDiv.offsetWidth + 'px';
        this.myIframe.style.height = this.rootDiv.offsetHeight + 'px';
    },

    /* *
     * 特定键盘事件，上、下、Enter键
     * @ KeyboardEvent
     * */

    KeyboardEvent:function(event,keycode){
        var lis = Vcity._m.$('li',this.ul);
        var len = lis.length;
        switch(keycode){
            case 40: //向下箭头↓
                this.count++;
                if(this.count > len-1) this.count = 0;
                for(var i=0;i<len;i++){
                    Vcity._m.removeClass('on',lis[i]);
                }
                Vcity._m.addClass('on',lis[this.count]);
                break;
            case 38: //向上箭头↑
                this.count--;
                if(this.count<0) this.count = len-1;
                for(i=0;i<len;i++){
                    Vcity._m.removeClass('on',lis[i]);
                }
                Vcity._m.addClass('on',lis[this.count]);
                break;
            case 13: // enter键
                this.input.value = Vcity.regExChiese.exec(lis[this.count].innerHTML)[0];
                Vcity._m.addClass('hide',this.ul);
                Vcity._m.addClass('hide',this.ul);
                /* IE6 */
                Vcity._m.addClass('hide',this.myIframe);
                break;
            default:
                break;
        }
    },

    /* *
     * 下拉列表的li事件
     * @ liEvent
     * */

    liEvent:function(){
        var that = this;
        var lis = Vcity._m.$('li',this.ul);
        for(var i = 0,n = lis.length;i < n;i++){
            Vcity._m.on(lis[i],'click',function(event){ 
                event = Vcity._m.getEvent(event);
                var target = Vcity._m.getTarget(event);
                that.input.value = Vcity.regExChiese.exec(target.innerHTML)[0];
                Vcity._m.addClass('hide',that.ul);
                /* IE6 下拉菜单点击事件 */
                Vcity._m.addClass('hide',that.myIframe);
            });
            Vcity._m.on(lis[i],'mouseover',function(event){
                event = Vcity._m.getEvent(event);
                var target = Vcity._m.getTarget(event);
                Vcity._m.addClass('on',target);
            });
            Vcity._m.on(lis[i],'mouseout',function(event){
                event = Vcity._m.getEvent(event);
                var target = Vcity._m.getTarget(event);
                Vcity._m.removeClass('on',target);
            })
        }
    }
};