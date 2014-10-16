// vim: sw=4:ts=4:nu:nospell:fdc=4
/**
* An Application
*
* @author    Ing. Jozef Sakalos
* @copyright (c) 2008, by Ing. Jozef Sakalos
* @date      2. April 2008
* @version   $Id$
*
* @license application.js is licensed under the terms of the Open Source
* LGPL 3.0 license. Commercial use is permitted to the extent that the
* code/component(s) do NOT become part of another Open Source or Commercially
* licensed development library or toolkit without explicit permission.
*
* License details: http://www.gnu.org/licenses/lgpl.html
*/
 
/*global Ext, Application */
 
Ext.BLANK_IMAGE_URL = '../app/extjs/resources/themes/images/default/tree/s.gif'; 
Ext.ns('Application');
 
// application main entry point
Ext.onReady(function() {
 
    Ext.QuickTips.init();
	Ext.Msg.alert('hello app', 'Application = ' + Application);
	console.dir(Application);
    // code here
 
}); // eo function onReady
 
// eof