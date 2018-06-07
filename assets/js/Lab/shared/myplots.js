function plot_force_direct_graph(){
	var colors = new Array("#912CEE", "#66ccff", "#8B008B", "#CD853F");

	var svg = d3.select("#cn"),
		width = +svg.attr("width"),
		height = +svg.attr("height");
		

	var simulation = d3.forceSimulation()
		.force("link", d3.forceLink().id(function(d) { return d.id; }))
		.force("charge", d3.forceManyBody())
		.force("center", d3.forceCenter(width / 2, height / 2));
		
	d3.json(force_direct_graph_source, function(error, graph) {
	  if (error) throw error;

	  var link = svg.append("g")
		  .attr("class", "links")
		.selectAll("line")
		.data(graph.links)
		.enter().append("line")
		  .attr("stroke-width", function(d) { return Math.sqrt(d.value); });

	  var node = svg.append("g")
		  .attr("class", "nodes")
		.selectAll("circle")
		.data(graph.nodes)
		.enter().append("circle")
		  .attr("r", 5)
		  .attr("fill", function(d) { return colors[d.group-1]; })
		  .call(d3.drag()
			  .on("start", dragstarted)
			  .on("drag", dragged)
			  .on("end", dragended));

	  node.append("title")
		  .text(function(d) { return d.id; });

	  simulation
		  .nodes(graph.nodes)
		  .on("tick", ticked);

	  simulation.force("link")
		  .links(graph.links);

	  function ticked() {
		link
			.attr("x1", function(d) { return d.source.x; })
			.attr("y1", function(d) { return d.source.y; })
			.attr("x2", function(d) { return d.target.x; })
			.attr("y2", function(d) { return d.target.y; });

		node
			.attr("cx", function(d) { return d.x; })
			.attr("cy", function(d) { return d.y; });
	  }
	});

	function dragstarted(d) {
	  if (!d3.event.active) simulation.alphaTarget(0.3).restart();
	  d.fx = d.x;
	  d.fy = d.y;
	}

	function dragged(d) {
	  d.fx = d3.event.x;
	  d.fy = d3.event.y;
	}

	function dragended(d) {
	  if (!d3.event.active) simulation.alphaTarget(0);
	  d.fx = null;
	  d.fy = null;
	}
}

function plot_publication_increament(mode=1){
    

	var svg = d3.select("#pi" + mode),
		margin = {
			top: 20,
			right: 20,
			bottom: 30,
			left: 50
		},
		width = +svg.attr("width") - margin.left - margin.right,
		height = +svg.attr("height") - margin.top - margin.bottom,
		g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");
    
	var x = d3.scaleLinear()
		.rangeRound([0, width]);
		
	var y = d3.scaleLinear()
		.rangeRound([height, 0]);

	var line = d3.line()
		.x(function(d) { return x(d.year); })
		.y(function(d) { return y(d.publication); });
		
	var area = d3.area()
		.x(function(d) { return x(d.year); })
		.y1(function(d) { return y(d.publication); });
	
	function plot_area(data, ylabel){
			x.domain([d3.min(data, function(d){ return +d.year - 1; }), d3.max(data, function(d){ return +d.year + 1; })]);
			y.domain([0, d3.max(data, function(d){ return +d.publication + 1; })]);
			area.y0(y(0));
			
			g.append("path")
				.datum(data)
				.attr("fill", "steelblue")
				.attr("d", area);
			
			g.append("g")
				.attr("transform", "translate(0," + height + ")")
				.call(d3.axisBottom(x))
				.attr("class", "axis")
			 .append("text")
				.attr("fill", "#000")
				.attr("x", 800)
				.attr("dy", "-0.5em")
				.attr("text-anchor", "start")
				.text("Year")
			
			g.append("g")
				.call(d3.axisLeft(y))
				.attr("class", "axis")
			 .append("text")
				.attr("fill", "#000")
				.attr("transform", "rotate(-90)")
				.attr("y", 6)
				.attr("dy", "0.71em")
				.attr("text-anchor", "end")
				.text(ylabel);
	}
	
	if(mode==1){
		d3.json(publication_increament_source_1, function(error, data){
			if(error) throw error;
			
			plot_area(data, "Annual Publication");
		});
	}
	else if(mode==2){
		d3.json(publication_increament_source_2, function(error, data){
			if(error) throw error;
			
			plot_area(data, "Total Publication")
		});
	}
}

function iqr(k) {
		return function(d, i) {
			var q1 = d.quartiles[0],
				q3 = d.quartiles[2],
				iqr = (q3 - q1) * k,
				i = -1,
				j = d.length;
			while (d[++i] < q1 - iqr);
			while (d[--j] > q3 + iqr);
			return [i, j];
		};
	}

(function() {

// Inspired by http://informationandvisualization.de/blog/box-plot
d3.box = function() {
  var width = 1,
      height = 1,
      duration = 0,
      domain = null,
      value = Number,
      whiskers = boxWhiskers,
      quartiles = boxQuartiles,
      tickFormat = null;

  // For each small multiple…
  function box(g) {
    g.each(function(d, i) {
      d = d.map(value).sort(d3.ascending);
      var g = d3.select(this),
          n = d.length,
          min = d[0],
          max = d[n - 1];

      // Compute quartiles. Must return exactly 3 elements.
      var quartileData = d.quartiles = quartiles(d);

      // Compute whiskers. Must return exactly 2 elements, or null.
      var whiskerIndices = whiskers && whiskers.call(this, d, i),
          whiskerData = whiskerIndices && whiskerIndices.map(function(i) { return d[i]; });

      // Compute outliers. If no whiskers are specified, all data are "outliers".
      // We compute the outliers as indices, so that we can join across transitions!
      var outlierIndices = whiskerIndices
          ? d3.range(0, whiskerIndices[0]).concat(d3.range(whiskerIndices[1] + 1, n))
          : d3.range(n);

      // Compute the new x-scale.
      var x1 = d3.scale.linear()
          .domain(domain && domain.call(this, d, i) || [min, max])
          .range([height, 0]);

      // Retrieve the old x-scale, if this is an update.
      var x0 = this.__chart__ || d3.scale.linear()
          .domain([0, Infinity])
          .range(x1.range());

      // Stash the new scale.
      this.__chart__ = x1;

      // Note: the box, median, and box tick elements are fixed in number,
      // so we only have to handle enter and update. In contrast, the outliers
      // and other elements are variable, so we need to exit them! Variable
      // elements also fade in and out.

      // Update center line: the vertical line spanning the whiskers.
      var center = g.selectAll("line.center")
          .data(whiskerData ? [whiskerData] : []);

      center.enter().insert("line", "rect")
          .attr("class", "center")
          .attr("x1", width / 2)
          .attr("y1", function(d) { return x0(d[0]); })
          .attr("x2", width / 2)
          .attr("y2", function(d) { return x0(d[1]); })
          .style("opacity", 1e-6)
        .transition()
          .duration(duration)
          .style("opacity", 1)
          .attr("y1", function(d) { return x1(d[0]); })
          .attr("y2", function(d) { return x1(d[1]); });

      center.transition()
          .duration(duration)
          .style("opacity", 1)
          .attr("y1", function(d) { return x1(d[0]); })
          .attr("y2", function(d) { return x1(d[1]); });

      center.exit().transition()
          .duration(duration)
          .style("opacity", 1e-6)
          .attr("y1", function(d) { return x1(d[0]); })
          .attr("y2", function(d) { return x1(d[1]); })
          .remove();

      // Update innerquartile box.
      var box = g.selectAll("rect.box")
          .data([quartileData]);

      box.enter().append("rect")
          .attr("class", "box")
          .attr("x", 0)
          .attr("y", function(d) { return x0(d[2]); })
          .attr("width", width)
          .attr("height", function(d) { return x0(d[0]) - x0(d[2]); })
        .transition()
          .duration(duration)
          .attr("y", function(d) { return x1(d[2]); })
          .attr("height", function(d) { return x1(d[0]) - x1(d[2]); });

      box.transition()
          .duration(duration)
          .attr("y", function(d) { return x1(d[2]); })
          .attr("height", function(d) { return x1(d[0]) - x1(d[2]); });

      // Update median line.
      var medianLine = g.selectAll("line.median")
          .data([quartileData[1]]);

      medianLine.enter().append("line")
          .attr("class", "median")
          .attr("x1", 0)
          .attr("y1", x0)
          .attr("x2", width)
          .attr("y2", x0)
        .transition()
          .duration(duration)
          .attr("y1", x1)
          .attr("y2", x1);

      medianLine.transition()
          .duration(duration)
          .attr("y1", x1)
          .attr("y2", x1);

      // Update whiskers.
      var whisker = g.selectAll("line.whisker")
          .data(whiskerData || []);

      whisker.enter().insert("line", "circle, text")
          .attr("class", "whisker")
          .attr("x1", 0)
          .attr("y1", x0)
          .attr("x2", width)
          .attr("y2", x0)
          .style("opacity", 1e-6)
        .transition()
          .duration(duration)
          .attr("y1", x1)
          .attr("y2", x1)
          .style("opacity", 1);

      whisker.transition()
          .duration(duration)
          .attr("y1", x1)
          .attr("y2", x1)
          .style("opacity", 1);

      whisker.exit().transition()
          .duration(duration)
          .attr("y1", x1)
          .attr("y2", x1)
          .style("opacity", 1e-6)
          .remove();

      // Update outliers.
      var outlier = g.selectAll("circle.outlier")
          .data(outlierIndices, Number);

      outlier.enter().insert("circle", "text")
          .attr("class", "outlier")
          .attr("r", 5)
          .attr("cx", width / 2)
          .attr("cy", function(i) { return x0(d[i]); })
          .style("opacity", 1e-6)
        .transition()
          .duration(duration)
          .attr("cy", function(i) { return x1(d[i]); })
          .style("opacity", 1);

      outlier.transition()
          .duration(duration)
          .attr("cy", function(i) { return x1(d[i]); })
          .style("opacity", 1);

      outlier.exit().transition()
          .duration(duration)
          .attr("cy", function(i) { return x1(d[i]); })
          .style("opacity", 1e-6)
          .remove();

      // Compute the tick format.
      var format = tickFormat || x1.tickFormat(8);

      // Update box ticks.
      var boxTick = g.selectAll("text.box")
          .data(quartileData);

      boxTick.enter().append("text")
          .attr("class", "box")
          .attr("dy", ".3em")
          .attr("dx", function(d, i) { return i & 1 ? 6 : -6 })
          .attr("x", function(d, i) { return i & 1 ? width : 0 })
          .attr("y", x0)
          .attr("text-anchor", function(d, i) { return i & 1 ? "start" : "end"; })
          .text(format)
        .transition()
          .duration(duration)
          .attr("y", x1);

      boxTick.transition()
          .duration(duration)
          .text(format)
          .attr("y", x1);

      // Update whisker ticks. These are handled separately from the box
      // ticks because they may or may not exist, and we want don't want
      // to join box ticks pre-transition with whisker ticks post-.
      var whiskerTick = g.selectAll("text.whisker")
          .data(whiskerData || []);

      whiskerTick.enter().append("text")
          .attr("class", "whisker")
          .attr("dy", ".3em")
          .attr("dx", 6)
          .attr("x", width)
          .attr("y", x0)
          .text(format)
          .style("opacity", 1e-6)
        .transition()
          .duration(duration)
          .attr("y", x1)
          .style("opacity", 1);

      whiskerTick.transition()
          .duration(duration)
          .text(format)
          .attr("y", x1)
          .style("opacity", 1);

      whiskerTick.exit().transition()
          .duration(duration)
          .attr("y", x1)
          .style("opacity", 1e-6)
          .remove();
    });
    d3.timer.flush();
  }

  box.width = function(x) {
    if (!arguments.length) return width;
    width = x;
    return box;
  };

  box.height = function(x) {
    if (!arguments.length) return height;
    height = x;
    return box;
  };

  box.tickFormat = function(x) {
    if (!arguments.length) return tickFormat;
    tickFormat = x;
    return box;
  };

  box.duration = function(x) {
    if (!arguments.length) return duration;
    duration = x;
    return box;
  };

  box.domain = function(x) {
    if (!arguments.length) return domain;
    domain = x == null ? x : function(x){return x;};
    return box;
  };

  box.value = function(x) {
    if (!arguments.length) return value;
    value = x;
    return box;
  };

  box.whiskers = function(x) {
    if (!arguments.length) return whiskers;
    whiskers = x;
    return box;
  };

  box.quartiles = function(x) {
    if (!arguments.length) return quartiles;
    quartiles = x;
    return box;
  };

  return box;
};

function boxWhiskers(d) {
  return [0, d.length - 1];
}

function boxQuartiles(d) {
  return [
    d3.quantile(d, .25),
    d3.quantile(d, .5),
    d3.quantile(d, .75)
  ];
}

})();

function plot_box_chart(){
	var svg = d3.select("#rbp"),
		margin = {top: 10, right: 50, bottom: 20, left: 50},
		width = +svg.attr("width") - margin.left - margin.right,
		height = +svg.attr("height") - margin.top - margin.bottom;

	var min = Infinity,
	max = -Infinity;

	var chart = d3.box()
		.whiskers(iqr(1.5))
		.width(width)
		.height(height);

	d3.json(box_chart_source, function(error, ori_data) {
	if (error) throw error;

	var data = [];

	for(var i=0;i<ori_data.length;i++){
		s = ori_data[i].reference;
		d = data[ori_data[i].year] = s;
		for(var j=0;j<s.length;j++){
			if (s[j] > max) max = s[j];
			if (s[j] < min) min = s[j];
		}
	}

	chart.domain([min, max]);

	svg.data(data)
	  .attr("class", "box")
	  .attr("width", width + margin.left + margin.right)
	  .attr("height", height + margin.bottom + margin.top)
	.append("g")
	  .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
	  .call(chart);

	setInterval(function() {
	svg.datum(randomize).call(chart.duration(1000));
	}, 2000);
	});

	function randomize(d) {
	if (!d.randomizer) d.randomizer = randomizer(d);
	return d.map(d.randomizer);
	}

	function randomizer(d) {
	var k = d3.max(d) * .02;
	return function(d) {
	return Math.max(min, Math.min(max, d + k * (Math.random() - .5)));
	};
	}

	// Returns a function to compute the interquartile range.
	
	
};
	



