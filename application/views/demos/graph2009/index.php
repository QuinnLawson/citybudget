	<style type="text/css">  		
		div{
  			float:left;
  		}
  		div3{
  			float:none;
  		}
  	</style>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script type="text/javascript">
var chart;
var chart2;
var chart3;
var approved2009;
var actual2009;
var data;

function grow(){
	slice = 2;
	val = approved2009.getValue(slice, 1);
	/*while(val < 100000000){
		val = val + 1000;
		approved2009.setValue(slice,1,approved2009.getValue(slice, 1)+val);
		chart.draw(approved2009, {width: 900, height: 600, title: 'My Daily Activities'});
	}*/
	
}


function abc(budget){  
    approved2009 = new google.visualization.DataTable();
    approved2009.addColumn('string', 'Organization');
    approved2009.addColumn('number', '$ Funded');
    
    actual2009 = new google.visualization.DataTable();
    actual2009.addColumn('string', 'Organization');
    actual2009.addColumn('number', '$ Funded');
    
    var data = new google.visualization.DataTable();
	data.addColumn('string', 'Organization');
    data.addColumn('number', 'Approved');
    data.addColumn('number', 'Actual');

    
	console.log(budget); 
	count = budget.__count__;
    approved2009.addRows(count);
    actual2009.addRows(count);
    data.addRows(count);
    
    var i = 0;
    $.each(budget, function(o, org){
   		approved2009.setValue(i, 0, org['name']);
    	approved2009.setValue(i, 1, org['total_approved']);
   		  actual2009.setValue(i, 0, org['name']);
    	  actual2009.setValue(i, 1, org['total_actual']);
    	data.setValue(i, 0, org['name']);
    	data.setValue(i, 1, org['total_approved']);
    	data.setValue(i, 2, org['total_actual']);
    	i = i+1;
    });

    chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(approved2009, {width: 380, height: 250, title: 'Approved Budget 2009'});

    chart2 = new google.visualization.PieChart(document.getElementById('chart2_div'));
    chart2.draw(actual2009, {width: 350, height: 250, title: 'Actual Budget 2009', legend: 'none'});
    
    chart3 = new google.visualization.ColumnChart(document.getElementById('chart3_div'));
    chart3.draw(data, {width: 740, height: 240, title: 'Approved and Actual 2009 Budget',
                          hAxis: {title: 'Organization', titleTextStyle: {color: 'red'}}
                         });
                         
    google.visualization.events.addListener(chart, 'select', selectHandler);
    google.visualization.events.addListener(chart2, 'select', selectHandler);
    google.visualization.events.addListener(chart3, 'select', selectHandler);
	

}
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
	$.ajax({ 
		url:'http://budget.opendatalondon.ca/index.php/api/budget/year/2009/format/jsonp', 
		type:'GET',  
		dataType:'jsonp', 
		success: abc 
	});
}

$(document).ready(function(){
});

function selectHandler(){
	i = this.getSelection();
	chart2.setSelection(chart.getSelection());
	i = chart2.getSelection();
	chart2.highlightRow(chart2.getSelection(), true);
	chart3.highlightRow(chart2.getSelection(), true);
	console.log(i[0]['row']);
}

    
    </script>

    <div id="chart_div"></div>
    <div id="chart2_div"></div>
    <div id="chart3_div"></div>