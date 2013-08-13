

var PCT = {
	pid:0,
	cid:0,
	tid:0,
	pobj:null,
	cobj:null,
	tobj:null,
	pctaddr:null,

	init:function(provid,cityid,townid){
		this.pobj=provid;
		this.cobj=cityid;
		this.tobj=townid;
		this.prov(provid);
		this.city(provid,cityid);
		this.town(cityid,townid);
	},
	w:function(id,o){
		$(id).append("<option value='"+o[0]+"'>"+o[1]+"</option>");
	},
	prov:function(provid){
		$(provid).empty();
		for(i=0;i<provArr.length;i++){
			this.w(provid,provArr[i]);
		}
	},
	city:function(provid,cityid){
		$(cityid).empty();
		this.pid = $(provid).val();
		for(i=0;i<cityArr.length;i++){
			if(cityArr[i][2] == this.pid)
				this.w(cityid,cityArr[i]);
		}
	},
	town:function(cityid,townid){
		$(townid).empty();
		this.cid = $(cityid).val();
		for(i=0;i<townArr.length;i++){
			if(townArr[i][2]==this.cid)
				this.w(townid,townArr[i]);
		}
	},
	val:function(id,v){
		$(id).val(v);
	},
	provc:function(){
		$(PCT.cobj).empty();
		PCT.city(PCT.pobj,PCT.cobj);
		PCT.town(PCT.cobj,PCT.tobj);
	},
	cityc:function(){
		$(PCT.tobj).empty();
		PCT.town(PCT.cobj,PCT.tobj);
	},
	townc:function(){
	},
	defval:function(p,c,t){
		$(PCT.pobj).val(p);
		this.city(PCT.pobj,PCT.cobj);
		$(PCT.cobj).val(c);
		this.town(this.cobj,this.tobj);
		$(PCT.tobj).val(t);
	}
};

