// debugger
import './chart.scss'
import Chart from 'chart.js/auto'

export default class MyChart{
   constructor(){
      this.income()
   }

   income(){}

}
(async function () {
  if (!document.getElementById('income')) return false;

  Chart.defaults.color = 'white';

  let data = [
    {year: 2010, count: 10},
    {year: 2011, count: 29},
    {year: 2012, count: 15},
    {year: 2013, count: 5},
    {year: 2014, count: 2},
    {year: 2015, count: 30},
    {year: 2016, count: 15},
  ];

  new Chart(
    document.getElementById('income'),
    {
      type: 'bar',
      data: {
        labels: data.map(row => row.year),
        datasets:
          // datasets(income,'Отгружено',150, 255, 100)
          [
          {
            label: 'Пирбыль за год',
            data: data.map(row => row.count),
            backgroundColor: data.map(row=>`rgba(150,255,${row.count*6},1)`)
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
    }
  );


  /// 2 supplied
  data = [
    {year: 2010, count: 1},
    {year: 2011, count: 8},
    {year: 2012, count: 15},
    {year: 2013, count: 4},
    {year: 2014, count: 5},
    {year: 2015, count: 12},
    {year: 2016, count: 1},
  ];

  new Chart(
    document.getElementById('supplied'),
    {
      type: 'bar',
      data: {
        labels: data.map(row => row.year),
        datasets:
        // datasets(income,'Отгружено',150, 255, 100)
          [
            {
              label: 'Пирбыль за год',
              data: data.map(row => row.count),
              backgroundColor: data.map(row=>`rgba(150,${row.count*6},255,1)`)
            }
          ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
    }
  );


  /// 3 newCustomers
  data = [
    {year: 2010, count: 10},
    {year: 2011, count: 20},
    {year: 2012, count: 15},
    {year: 2013, count: 25},
    {year: 2014, count: 7},
    {year: 2015, count: 2},
    {year: 2016, count: 5},
  ];

  new Chart(
    document.getElementById('newCustomers'),
    {
      type: 'bar',
      data: {
        labels: data.map(row => row.year),
        datasets:
        // datasets(income,'Отгружено',150, 255, 100)
          [
            {
              label: 'Пирбыль за год',
              data: data.map(row => row.count),
              backgroundColor: data.map(row=>`rgba(150,255,${row.count*6},1)`)
            }
          ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
    }
  );


  /// 2 коэфф
  data = [
    {year: 2010, count: 30},
    {year: 2011, count: 2},
    {year: 2012, count: 15},
    {year: 2013, count: 25},
    {year: 2014, count: 2},
    {year: 2015, count: 16},
    {year: 2016, count: 10},
  ];

  new Chart(
    document.getElementById('coefficient'),
    {
      type: 'bar',
      data: {
        labels: data.map(row => row.year),
        datasets:
        // datasets(income,'Отгружено',150, 255, 100)
          [
            {
              label: 'Пирбыль за год',
              data: data.map(row => row.count),
              backgroundColor: data.map(row=>`rgba(150,255,${row.count*6},1)`)
            }
          ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
    }
  );






  function datasets(data,name,one,two,three) {
    return {
      label:name,
      data: data.map(row => row.count),//150 255 ${row.count*6}
      backgroundColor: data.map(row=>`rgba(${one},${two},${three},1)`)
    }
  }


})();

