/**
 * Search toolbar. 
 * Allows you to search in the set of fields. 
 * Uses content filtering. 
 * @author Kirill A Egorov 2011
 */
Ext.define('SearchPanel', {
        extend:'Ext.toolbar.Toolbar',
        alias:'widget.searchpanel',
        /**
         * @var {Ext.form.TextField}
         */
        searchField:null,
        /**
         * @var {Ext.Button} 
         */
        resetButton:null,
        /**
         * @var {Ext.data.Store}
         */
        store:null,
        /**
         * @var {Array}
         */
        fieldNames:[],
        /**
         * @property string  - local / remote
         */
        local:false,
        
        searchParam:'search',
        
        constructor: function(config) {
                
                config = Ext.apply({
                        frame:false,
                        border:false,
                        bodyBorder:false,
                        width:230,
                        hideLabel:false,
                        frame:false,
                        style: {
                        border:0
                    }
                } , config);
                
                this.callParent(arguments);
        },
        
        initComponent:function(){

                this.resetButton = Ext.create('Ext.Button',{
                             icon:'../../../../i/system/delete.gif',
                             flat:false,
                             tooltip:appLang.RESET_SEARCH,
                             listeners:{
                                 'click':{
                                         fn:function(){
                                                 this.searchField.setValue('');
                                                 this.clearFilter();                                    
                                         },
                                         scope:this
                                 }
                             }
                });
                
                this.searchField = Ext.create('Ext.form.field.Text',{
                        //width:this.width - 30,
                        enableKeyEvents:true,
                        flex:2,
                        listeners:{
                                'keyup' : {
                                        fn:this.startFilter,
                                        buffer:550,
                                        scope: this
                                }
                        }
                });
                this.items = [];
                
                if(!this.hideLabel){
                        this.items.push(appLang.SEARCH+':');
                }
                
                this.items.push(this.searchField , this.resetButton);
                this.callParent(arguments);
        },
        /**
         * Clear filter
         */
        clearFilter:function(){ 
                this.store.clearFilter();
                if(!this.local){
                        this.store.proxy.extraParams[this.searchParam]='';
                        this.store.load();
                }
        },
        /**
         * Start filtering data
         */
        startFilter : function(){               
        
                if(this.local){         
                        this.clearFilter();
                        if(!this.searchField.getValue().length){
                                return
                        }       
                        this.store.filter({fn:this.isSerched,scope:this});      
                } else {                 

                        this.store.proxy.extraParams[this.searchParam] = this.searchField.getValue();
                        this.store.load();
                }       
        },
        /**
         * Record filter function
         */
        isSerched : function(record){           
                var flag = false;
                var recordHandle = record;
                var searchText = this.searchField.getValue();
                var pattern = new RegExp(searchText,"gi");
                
                Ext.each(this.fieldNames, function(item){
                        if(pattern.exec(recordHandle.get(item)) != null){
                                flag = true;
                                return;
                        }
                }, this);
        
                return flag;
        }
});
