/** define custom sorter and widgets for tablesorter plugin for jQuery
* @since 10/4/2008
* @author Son Nguyen
*/

// add sorting by 1,300,000 (with commas)
$.tablesorter.addParser({
 id: "fwnumber",
 is: function(s) {
  return false;
 },
 format: function(s) {
  return $.tablesorter.formatFloat(s.replace(/(\,|\%)/g,""));
 },
 type: "numeric"
});


// only look for value in the comment, eg: <!--text--><IMG>, 
$.tablesorter.addParser({
 id: "commenttxt",
 is: function(s) { 
  return /^<!--([a-z]+)-->/.test($.trim(s));
 },
 format: function(s) {
  return s.replace(/^<!--([a-z]+)-->.*/g,"$1");
 },
 type: "text"
});

// only look for value in the comment, eg: <!--21928--><DATE>
$.tablesorter.addParser({
 id: "commentnum",
 is: function(s) { 
  return /^<!--([0-9]+)-->/.test($.trim(s));
 },
 format: function(s) {
  return s.replace(/^<!--([0-9]+)-->.*/g,"$1");
 },
 type: "numeric"
});


// show the hover row different than other rows
$.tablesorter.addWidget({
 id: "rowHover",
 format: function(table) {
  $("tr:visible",table.tBodies[0]).hover(
   function () { $(this).addClass(table.config.widgetRowHover.css); },
   function () { $(this).removeClass(table.config.widgetRowHover.css); }
  );
 }
}); 

// apply CSS to the sortable header when mouse hovers it
$.tablesorter.addWidget({
 id: "headerHover",
 format: function(table) {
  $("thead th:visible",table).hover(
   function () { if (!table.config.headerList[$("thead th:visible",table).index(this)].sortDisabled) $(this).addClass(table.config.widgetHeaderHover.css); },
   function () { $(this).removeClass(table.config.widgetHeaderHover.css); }
  );
 }
}); 

// call a link via AJAX to save/memorize the sort order
$.tablesorter.addWidget({
 id: "memorizeSortOrder",
 format: function(table) {
  if (!table.config.widgetMemorizeSortOrder.isBinded) { // only bind if not already binded
   table.config.widgetMemorizeSortOrder.isBinded = true;
   $("thead th:visible",table).click(function() {
    var i = $("thead th:visible",table).index(this);
    $.get(table.config.widgetMemorizeSortOrder.url+i+'|'+table.config.headerList[i].order);
   });
  } // fi
 }
}); 
