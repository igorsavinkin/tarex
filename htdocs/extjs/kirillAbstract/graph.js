Ext.ns('app.graph');

Ext.define('app.graph.Monitor',{
    extend:'Ext.Panel',

    padding:10,

    monitorName:'',

    chartStore:null,

    dataPanel:null,

    itemHtml:'',
    dataChart:null,

    controllerUrl:'',

    dataFrom:null,
    dataTo:null,

    layout:'card',
    activeItem: 0,

    deferredRender:true,
    defaultInterval:3,

    controllerUrl:'',

    initComponent:function(){

		this.startDate = Ext.Date.format(Ext.Date.subtract(new Date(), Ext.Date.DAY, this.defaultInterval), 'Y-m-d');
		this.endDate =  Ext.Date.format(new Date(), 'Y-m-d');

		this.initToolbar();
		this.initChart();
		this.initPanel();
		this.items = [this.dataChart , this.dataPanel];
		this.callParent();
    }, // eo initComponent

    initToolbar:function(){

		var cmpGroup = this.monitorName + '_monitor';

		this.dataFrom = Ext.create('Ext.form.field.Date',{
			width:85,
			value: this.startDate,
			format:'d.m.Y',
			maxValue: new Date(),
			listeners:{
			change:{
				fn:function(field , newValue){
				this.chartStore.proxy.setExtraParam('from' , Ext.Date.format(field.getValue(),'Y-m-d'));
				this.reloadData();
				},
				scope:this
			}
			}
	});

	this.dataTo = Ext.create('Ext.form.field.Date',{
	    width:85,
	    value: this.endDate,
	    format:'d.m.Y',
	    maxValue: new Date(),
	    listeners:{
		change:{
		    fn:function(field , newValue){
			this.chartStore.proxy.setExtraParam('to' , Ext.Date.format(field.getValue(),'Y-m-d'));
			this.reloadData();
		    },
		    scope:this
		}
	    }
	});

	this.tbar = [
	  {
	      tooltip:'График',
	      enableToggle:true,
	      toggleGroup: cmpGroup,
	      text:'chart',
	      icon:'./chart.png',
	      pressed:true,
	      listeners:{
			  toggle:{
				  fn:function(btn , pressed){
					  if(pressed){
						  this.getLayout().setActiveItem('graph');
					  }
				  },
				  scope:this
			  }
	      }
	  },{
	      tooltip:'Таблица',
	      text:'grid',
	      enableToggle:true,
	      toggleGroup:cmpGroup,
	      icon:'./grid.png',
	      listeners:{
		  toggle:{
		      fn:function(btn , pressed){
			  if(pressed){
			      this.getLayout().setActiveItem('dpanel');
			  }
		      },
		      scope:this
		  }
	      }
	  },
	  'С',
	  this.dataFrom,
	  'По',
	  this.dataTo,
	  {
	      tooltip:'Скачать',
	      icon:'./excel.png',
	      handler:function(){
		  window.location = this.controllerUrl + 'download?from='+Ext.Date.format(this.dataFrom.getValue(),'Y-m-d')+'&to='+Ext.Date.format(this.dataTo.getValue(),'Y-m-d')+'&monitor='+this.monitorName;
	      },
	      scope:this
	  }
	];
    },
    /**
     * Reload monitor data
     */
    reloadData:function(){
		this.chartStore.load();
    },
    initChart:function(){

	this.chartStore = Ext.create("Ext.data.Store",	{
		xtype:"store",
		autoLoad:true,
		fields:[
		  {name:'date', type:'string'},
		  {name:'data1',type:'int'},
		],
		proxy:{
		        extraParams:{
		            'monitor':this.monitorName,
		            'from': this.startDate,
		            'to':this.endDate
		        },
			url: this.controllerUrl + 'chart',
			reader:{
			  idProperty:"id",
			  root:"data"
			},
			type:"ajax"
		},
		listeners:{
		    beforeload:{
			fn:function(){
			    this.dataChart.getEl().mask('Загрузка');
			},
			scope:this
		    },
		    load:{
			fn:function(){
			    this.dataChart.getEl().unmask();
			},
			scope:this
		    },
		}
	});

	this.dataChart = Ext.create('Ext.chart.Chart', {
	        animate: false,
	        shadow: true,
	        store: this.chartStore,
	        itemId:'graph',
	        seriesStyle:{
	            fill: '#000'
	        },
	        axes: [{
	            type: 'Numeric',
	            position: 'left',
	            fields: ['data1'],
	            title: 'Значение',
	            grid:true,
	            minimum: 0,
	            adjustMinimumByMajorUnit: 0
	        }, {
	            type: 'Category',
	            position: 'bottom',
	            fields: ['date'],
	            title: 'Дата',
	            label: {
	                rotate: {
	                    degrees: 270
	                }
	            }
	        }],
	        series: [
	                 {
	            type: 'area',
	            highlight: true,
	            axis: 'left',
	            gutter: 80,
	            xField: 'date',
	            yField: ['data1'],
	            renderer: function(sprite, record, attr, index, store){
	        	    return Ext.apply(attr, {
	                        fill: '#008000'
	                    });
	            },
	            tips: {
	        	width: 140,
	        	height: 40,
	                trackMouse: true,
	                renderer: function(storeItem, item) {
	                    this.setTitle(storeItem.get('date'));
	                    this.update(storeItem.get('data1'));
	                }
	            },
	            style: {
	        	stroke: '#000',
	                'stroke-width': 1,
	                opacity: 0.9
	            }
	        }]
	    });
    },
    initPanel:function(){
	this.dataPanel = Ext.create("Ext.Panel",{
	    itemId:'dpanel',
	    html:this.itemHtml
        });
    }
}); // eo Ext.define('app.graph.Monitor', ...

Ext.define('app.graph.First',{
    extend:'app.graph.Monitor',
    monitorName:'first',
    initComponent:function(){
	this.itemHtml = '<hr><h3>First</h3>'
	this.callParent();
    }
});

Ext.define('app.graph.Last',{
    extend:'app.graph.Monitor',
    monitorName:'last',
    initComponent:function(){
	this.itemHtml = '<hr><h3>Last</h3>'
	this.callParent();
    }
});

Ext.define('app.graph.Counter',{
    extend:'app.graph.Monitor',
    monitorName:'counter',
    defaultInterval:60,
    initComponent:function(){

	this.itemHtml = '<hr><h3>Counters</h3>'

	this.dataFields = [
	      {name:'data1' , type:'int'},
	      {name:'data2' , type:'int'},
	      {name:'data3' , type:'int'},
	      {name:'date' ,  type:'string'}
	];

	this.dataColumns = [
	      {
		  text:'Дата',
		  dataIndex:'date',
		  xtype: 'data1',
		  format:'d.m.y H:i',
		  sortable:false,
		  align:'center'
	      },{
		  text:'Data 1',
		  dataIndex:'data1',
		  sortable:false
	      },{
		  text:'Data 2',
		  dataIndex:'data2',
		  sortable:false
	      },{
		  text:'Data 3',
		  dataIndex:'data3',
		  sortable:false
	      }
	];
	this.callParent();
    },
    initChart:function()
    {
	this.chartStore = Ext.create("Ext.data.Store",	{
		xtype:"store",
		autoLoad:true,
		fields:[
		  {name:'date', type:'string'},
		  {name:'data1',type:'int'},
		  {name:'data2',type:'int'},
		  {name:'data3',type:'int'}
		],
		proxy:{
		        extraParams:{
		            'monitor':this.monitorName,
		            'from': this.startDate,
		            'to':this.endDate
		        },
			url: this.controllerUrl + 'chart',
			reader:{
			  idProperty:"id",
			  root:"data"
			},
			type:"ajax"
		},
		listeners:{
		    beforeload:{
			fn:function(){
			    this.dataChart.getEl().mask('Загрузка');
			},
			scope:this
		    },
		    load:{
			fn:function(){
			    this.dataChart.getEl().unmask();
			},
			scope:this
		    },
		}
	});

	this.dataChart = Ext.create('Ext.chart.Chart', {
	        animate: false,
	        shadow: true,
	        store: this.chartStore,
	        itemId:'graph',
	        seriesStyle:{
	            fill: '#000'
	        },
	        legend: {
	            position: 'bottom'
	        },
	        axes: [{
	            type: 'Numeric',
	            position: 'left',
	            fields: ['data1','data2','data3'],
	            title: 'Количество',
	            grid:true,
	            minimum: 0,
	            adjustMinimumByMajorUnit: 0
	        }, {
	            type: 'Category',
	            position: 'bottom',
	            fields: ['date'],
	            title: 'Дата',
	            label: {
	                rotate: {
	                    degrees: 270
	                }
	            }
	        }],
	        series: [
	            {
	            //type: 'area',
	            type:'column',
	            highlight: false,
	            axis: 'left',
	            gutter: 80,
	            xField: 'date',
	            yField: ['data1','data2','data3'],
	            tips: {
	        	width: 140,
	        	height: 80,
	                trackMouse: true,
	                renderer: function(storeItem, item) {
	                    this.setTitle('<center><b>' + storeItem.get('date')+'</b></center>');
	                    var text = 'Data 1: ' + storeItem.get('data1')+'<br>';
	                    text+= 'Data 2: ' + storeItem.get('data2')+'<br>';
	                    text+= 'Data 3: ' + storeItem.get('data3');
	                    this.update(text);
	                }
	            },
	            style: {
	        	stroke: '#000',
	                'stroke-width': 1,
	                opacity: 0.9,
	                //fill: 'rgb(213, 70, 121)' //'#38B8BF'
	            }
	        }
	       ]
	    });
    },
});  

Ext.define('app.graph.Main',{
   extend:'Ext.Panel',
   layout: 'fit',
   controllerUrl:'./data.php?',
   initComponent:function(){


       this.monitors = {};

       this.monitors.first = Ext.create('app.graph.First',{
	   title:'Монитор 1',
	   controllerUrl:this.controllerUrl,
	   flex:1
       });

       this.monitors.last = Ext.create('app.graph.Last',{
	   title:'Монитор 3',
	   controllerUrl:this.controllerUrl,
	   flex:1
       });

       this.monitors.counters = Ext.create('app.graph.Counter',{
	   title:'Счетчик',
	   controllerUrl:this.controllerUrl,
	   flex:1
       });


       this.items = [
                     {
                	xtype:'container',
                        layout: {
                            type: 'vbox',
                            align : 'stretch',
                            pack  : 'start',
                        },
                        frame:false,
                        border:false,
                        items: [
                            {
                        	xtype:'container',
                        	frame:false,
                                border:false,
                        	layout: {
                        	    type: 'hbox',
                        	    pack: 'start',
                        	    align: 'stretch'
                        	},
                        	items: [
                                    this.monitors.first,
                            	    this.monitors.last
                        	],
                        	flex:1
                            },{
                            	xtype:'container',
                            	frame:false,
                                border:false,
                             	layout: {
                             	    type: 'hbox',
                             	    pack: 'start',
                             	    align: 'stretch'
                             	},
                             	items: [
                             	 this.monitors.counters
                             	],
                             	flex:1
                             }
                        ]
                     }
       ];


       this.tbar = [
           {
              text:'Монитор 1',
              enableToggle:true,
              pressed:true,
              itemId:'first',
              listeners:{
                  toggle:{
         	      fn:this.onNavClicked,
         	      scope:this
         	  }
              }
 	   },
           {
 	      text:'Монитор 2',
 	      enableToggle:true,
              pressed:true,
              itemId:'last',
              listeners:{
                  toggle:{
         	      fn:this.onNavClicked,
         	      scope:this
         	  }
              }
 	   },'-',
           {
 	      text:'Монитор-Счетчик',
  	      enableToggle:true,
  	      itemId:'counters',
              pressed:true,
              listeners:{
                  toggle:{
         	      fn:this.onNavClicked,
         	      scope:this
         	  }
              }
  	  }
       ];

       this.callParent();
   },
   onNavClicked:function(btn , status){
       if(status){
	      this.monitors[btn.itemId].show();
	  }else{
	      this.monitors[btn.itemId].hide();
	  }
	 this.checkRowsState();
   },
   checkRowsState:function()
   {
       if(this.monitors.first.isHidden() && this.monitors.last.isHidden())
       {
	   this.monitors.first.up('container').hide();
       }else{
	   this.monitors.first.up('container').show();
       }

       if(this.monitors.counters.isHidden()){
	   this.monitors.counters.up('container').hide();
       }else{
	   this.monitors.counters.up('container').show();
       }
   }
});