import * as am4core from '@amcharts/amcharts4/core';
import * as am4charts from '@amcharts/amcharts4/charts';
import am4themes_animated from '@amcharts/amcharts4/themes/animated';

import axios from 'axios';
import { createApp } from '@vue/runtime-dom';
import UserRole from './Vue/components/UserRole.vue';
import User from './Vue/components/User.vue';
import ExpenseCategory from './Vue/components/ExpenseCategory.vue';
import Expenses from './Vue/components/Expenses.vue';
import Dashboard from './Vue/components/Dashboard.vue';
import $ from 'jquery';

require('./bootstrap');

require('alpinejs');


let app = Vue.createApp({
  delimiters: [ '${', '}' ],
  data() {
    return {
      inputData: {},
      user: {
        isAdmin: false,
        name: '',
        role: ''
      },
      expenseCategoty: {},
      dataForm: {
        title: '',
        add: true,
        update: false,
        show: false,
        data: {},
        loader: false,
      },
      systemAlert: {
        type: '',
        message: ''
      },
      header: {
        title: '',
        path: '',
      },
      selectedSideBar: window.location.pathname
    }
  },
  beforeMount() {
      axios.get('/api/user')
        .then(response => {
          this.user.isAdmin = response.data.role == 1;
          this.user.name = response.data.name;
          this.user.role = response.data.role_name;
        })
        .catch(err => console.log(err.message));
      
        if(window.location.pathname != '/dashboard')
        {
          fetch('/api'+window.location.pathname)
            .then(res => res.json())
            .then(data => this.dataForm.data = data)
            .catch(err => console.log(err.message));
        }
  },
  methods: {
  }
});

if(window.location.pathname == '/user/roles') {
  app.component('form-data', UserRole);
}
if(window.location.pathname == '/users') {
  app.component('form-data', User);
}
if(window.location.pathname == '/expenses/category') {
  app.component('form-data', ExpenseCategory);
}
if(window.location.pathname == '/expenses') {
  app.component('form-data', Expenses);
}
if(window.location.pathname == '/dashboard')
{
  app.component('form-data', Dashboard);
}


app.mount('#app');


let chart = am4core.create('expense_chart', am4charts.PieChart);

// Add data
if(window.location.pathname == '/dashboard')
{
  axios
      .get('/api/expenses/summary')
      .then(response => chart.data = response.data)
  
  setInterval(function(){
      axios
      .get('/api/expenses/summary')
      .then(response => chart.data = response.data)
  }, 5000);
}

am4core.useTheme(am4themes_animated);

// Add and configure Series
let pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "total";
pieSeries.dataFields.category = "category_name";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;
pieSeries.ticks.template.disabled = true;
pieSeries.labels.template.disabled = true;

chart.legend = new am4charts.Legend();
chart.legend.position = 'left';
chart.legend.valueLabels.template.text = "$ {value.value}";


$(function() {
  $('[name="_token"]').val($('[name="csrf-token"]').prop('content'));
})