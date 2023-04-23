import './chart.scss'

if (typeof  anychart!=='undefined') {
  ()=>{



anychart.onDocumentLoad(function () {


  if (!document.querySelector('#income')) return;
  let income = anychart.pie();
  income.data([
    ["Перчатки", 5],
    ["Шприцы", 2],
    ["Бахилы", 2],
    ["Нитрил", 2],
    ["Винил", 1]
  ]);
  income.legend(false);
  income.background('none');
  income.padding(0);
  income.container("income");
  income.draw();

  let supplied = anychart.pie();
  supplied.data([
    ["Перчатки", 5],
    ["Шприцы", 2],
    ["Бахилы", 2],
    ["Нитрил", 2],
    ["Винил", 1]
  ]);
  supplied.legend(false);
  supplied.background('none');
  supplied.padding(0);
  supplied.container("supplied");
  supplied.draw();

  let newCustomers = anychart.pie();
  newCustomers.data([
    ["Перчатки", 5],
    ["Шприцы", 2],
    ["Бахилы", 2],
    ["Нитрил", 2],
    ["Винил", 1]
  ]);
  newCustomers.legend(false);
  newCustomers.padding(0);
  newCustomers.background('none');
  newCustomers.container("newCustomers");
  newCustomers.draw();

  let coefficient = anychart.pie();
  coefficient.data([
    ["Перчатки", 5],
    ["Шприцы", 2],
    ["Бахилы", 2],
    ["Нитрил", 2],
    ["Винил", 1]
  ]);
  coefficient.legend(false);
  coefficient.background('none');
  coefficient.padding(0);
  coefficient.container("coefficient");
  coefficient.draw();

  //
  // anychart.theme('darkBlue');
  // var stage = acgraph.create('map');
  //
  //
  // anychart.data.loadJsonFile(
  //   'https://cdn.anychart.com/releases/8.11.0/geodata/custom/russia/russia.topo.json',
  //   function (data) {
  //     // create data set
  //     var dataSet = anychart.data.set(
  //       [{"id": "RU.SC", "value": 0},
  //         {"id": "RU.KR", "value": 1},
  //         {"id": "RU.2485", "value": 2},
  //         {"id": "RU.AR", "value": 3},
  //         {"id": "RU.NN", "value": 4},
  //         {"id": "RU.YN", "value": 5},
  //         {"id": "RU.KY", "value": 6},
  //         {"id": "RU.CK", "value": 7},
  //         {"id": "RU.KH", "value": 8},
  //         {"id": "RU.SL", "value": 9},
  //         {"id": "RU.KA", "value": 10},
  //         {"id": "RU.KT", "value": 11},
  //         {"id": "RU.MS", "value": 12},
  //         {"id": "RU.RZ", "value": 13},
  //         {"id": "RU.SA", "value": 14},
  //         {"id": "RU.UL", "value": 15},
  //         {"id": "RU.OM", "value": 16},
  //         {"id": "RU.NS", "value": 17},
  //         {"id": "RU.MM", "value": 18},
  //         {"id": "RU.LN", "value": 19},
  //         {"id": "RU.SP", "value": 20},
  //         {"id": "RU.KI", "value": 21},
  //         {"id": "RU.KC", "value": 22},
  //         {"id": "RU.IN", "value": 23},
  //         {"id": "RU.KB", "value": 24},
  //         {"id": "RU.NO", "value": 25},
  //         {"id": "RU.ST", "value": 26},
  //         {"id": "RU.SM", "value": 27},
  //         {"id": "RU.PS", "value": 28},
  //         {"id": "RU.TV", "value": 29},
  //         {"id": "RU.VO", "value": 30},
  //         {"id": "RU.IV", "value": 31},
  //         {"id": "RU.YS", "value": 32},
  //         {"id": "RU.KG", "value": 33},
  //         {"id": "RU.BR", "value": 34},
  //         {"id": "RU.KS", "value": 35},
  //         {"id": "RU.LP", "value": 36},
  //         {"id": "RU.2509", "value": 37},
  //         {"id": "RU.OL", "value": 38},
  //         {"id": "RU.NZ", "value": 39},
  //         {"id": "RU.PZ", "value": 40},
  //         {"id": "RU.VL", "value": 41},
  //         {"id": "RU.VR", "value": 42},
  //         {"id": "RU.KO", "value": 43},
  //         {"id": "RU.SV", "value": 44},
  //         {"id": "RU.BK", "value": 45},
  //         {"id": "RU.UD", "value": 46},
  //         {"id": "RU.MR", "value": 47},
  //         {"id": "RU.CV", "value": 48},
  //         {"id": "RU.CL", "value": 49},
  //         {"id": "RU.OB", "value": 50},
  //         {"id": "RU.SR", "value": 51},
  //         {"id": "RU.TT", "value": 52},
  //         {"id": "RU.TO", "value": 53},
  //         {"id": "RU.TY", "value": 54},
  //         {"id": "RU.GA", "value": 55},
  //         {"id": "RU.KK", "value": 56},
  //         {"id": "RU.CN", "value": 57},
  //         {"id": "RU.KL", "value": 58},
  //         {"id": "RU.DA", "value": 59},
  //         {"id": "RU.RO", "value": 60},
  //         {"id": "RU.BL", "value": 61},
  //         {"id": "RU.TU", "value": 62},
  //         {"id": "RU.IR", "value": 63},
  //         {"id": "RU.CT", "value": 64},
  //         {"id": "RU.YV", "value": 65},
  //         {"id": "RU.AM", "value": 66},
  //         {"id": "RU.TB", "value": 67},
  //         {"id": "RU.TL", "value": 68},
  //         {"id": "RU.NG", "value": 69},
  //         {"id": "RU.VG", "value": 70},
  //         {"id": "RU.KV", "value": 71},
  //         {"id": "RU.ME", "value": 72},
  //         {"id": "RU.KE", "value": 73},
  //         {"id": "RU.AS", "value": 74},
  //         {"id": "RU.PR", "value": 75},
  //         {"id": "RU.MG", "value": 76},
  //         {"id": "RU.BU", "value": 77},
  //         {"id": "RU.KN", "value": 78},
  //         {"id": "RU.KD", "value": 79},
  //         {"id": "RU.KU", "value": 80},
  //         {"id": "RU.AL", "value": 81},
  //         {"id": "RU.KM", "value": 82},
  //         {"id": "RU.PE", "value": 83},
  //         {"id": "RU.AD", "value": 84}]
  //     );
  //
  //     var map = anychart.map();
  //
  //     map
  //       .geoData(data)
  //       .colorRange(true);
  //
  //     var series = map.choropleth(dataSet);
  //     series
  //       .tooltip()
  //       .padding([0, 0, 0, 0])
  //       .fontSize(15)
  //       .title(false)
  //       .separator(false);
  //
  //     series.selectionMode('none').stroke('#B9B9B9');
  //
  //     series.hovered().fill('#b8b5d9');
  //
  //     map.background('none');
  //     map.container(stage);
  //     map.legend(false)
  //
  //     map.draw();
  //   }
  // );


});
  }
}



