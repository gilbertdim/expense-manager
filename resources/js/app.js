import * as am4core from '@amcharts/amcharts4/core';
import * as am4charts from '@amcharts/amcharts4/charts';
import am4themes_animated from '@amcharts/amcharts4/themes/animated';
import axios from 'axios';
import dateFormat from 'dateformat';

require('./bootstrap');

require('alpinejs');

let app = Vue.createApp({
    delimiters: [ '${', '}' ],
    data: function() {
        return { 
            formAction: 'Add Category',
            menuDashboard: window.location.pathname == '/dashboard',
            menuUserRole: window.location.pathname == '/user/roles',
            menuUsers: window.location.pathname == '/users',
            menuExpenseCategory: window.location.pathname == '/expenses/category',
            menuExpenses: window.location.pathname == '/expenses',
            isAdmin: false,
            isAdd: false,
            withDelete: false,
            showModal: false,
            showLoader: false,
            isShowMenu: true,
            formRole: false,
            formCategory: false,
            formUser: false,
            formExpense: false,
            maxExpenseEntryDate: dateFormat(new Date, 'yyyy-mm-dd'),
            profile:{
              name:'',
              role:''
            },
            data: {
              userRoles: [],
              expenseCategories: [],
              users: [],
              expenses: [],
            },
            id:'',
            user: {
              name: '',
              email: '',
              role: ''
            },
            role: {
              name:'',
              description:''
            },
            expenseCategory: {
              name:'',
              description:''
            },
            expense: {
              category:'',
              amount:'',
              entryDate: ''
            },
            alerts: {
              danger:{
                message: ''
              },
              primary:{
                message: ''
              },
              success:{
                message: ''
              },
            }
        }
    },
    methods: {
        addRole(){
            this.id = null;
            this.role.name = '';
            this.role.description = '';

            this.formAction = 'Add Role';
            this.isAdd = true;
            this.showModal = true;
            this.formRole = true;
        },
        updateRole(role)
        {
          if(role.id == 1)
          {
            this.alerts.danger.message = 'You cannot edit Administrator role';
          }
          else
          {
            this.id = role.id;
            this.role.name = role.name;
            this.role.description = role.description;
  
            this.formAction = 'Update Role';
            this.isAdd = false;
            this.showModal = true;
            this.formRole = true;
            this.withDelete = true;
          }
        },
        addUser()
        {
            this.id = null;
            this.user.name = '';
            this.user.email = '';
            this.user.role = '';

            this.formAction = 'Add User';
            this.isAdd = true;
            this.showModal = true;
            this.formUser = true;
            this.withDelete = false;
          },
        updateUser(user)
        {
          this.id = user.id;
          this.user.name = user.name;
          this.user.email = user.email;
          this.user.role = user.role_id;
          
          this.formAction = 'Update User';
          this.isAdd = false;
          this.showModal = true;
          this.formUser = true;
          this.withDelete = true;

          if(user.role_id == 1)
          {
            this.withDelete = false;
          }
        },
        addExpenseCategory()
        {
          this.id = null;
          this.expenseCategory.name = '';
          this.expenseCategory.description = '';

          this.formAction = 'Add Expense Category';
          this.isAdd = true;
          this.showModal = true;
          this.formCategory = true;
        },
        updateExpenseCategory(category)
        {
          this.id = category.id;
          this.expenseCategory.name = category.name;
          this.expenseCategory.description = category.description;

          this.formAction = 'Update Expense Category';
          this.isAdd = false;
          this.showModal = true;
          this.formCategory = true;
          this.withDelete = true;
        },
        addExpense()
        {
          this.id = null;
          this.expense.category = '';
          this.expense.amount = '';
          this.expense.entryDate = dateFormat(new Date, 'yyyy-mm-dd');

          this.formAction = 'Add Expense';
          this.isAdd = true;
          this.showModal = true;
          this.formExpense = true;
        },
        updateExpense(expense)
        {
          this.id = expense.id;
          this.expense.category = expense.category_id;
          this.expense.amount = expense.amount;
          this.expense.entryDate = expense.entry_date;

          this.formAction = 'Update Expense';
          this.isAdd = false;
          this.showModal = true;
          this.formExpense = true;
          this.withDelete = true;
        },
        getUserRoles(){
          fetch('/api/user/roles')
            .then(res => res.json())
            .then(data => this.data.userRoles = data)
            .catch(err => console.log(err.message));
        },
        getExpenseCategory()
        {
          fetch('/api/expense/categories')
            .then(res => res.json())
            .then(data => this.data.expenseCategories = data)
            .catch(err => console.log(err.message));      
        },
        getExpenses()
        {
          axios.get('/api/expenses')
            .then(response => this.data.expenses = response.data)
            .catch(err => console.log(err.message));
        },
        getUsers()
        {
          axios.get('/api/users')
            .then(response => this.data.users = response.data)
            .catch(err => console.log(err.message));
        },
        saveRecord(){
          var data = [];

          if(this.menuExpenses)
          {
            if(this.expense.entryDate > dateFormat(new Date, 'yyyy-mm-dd')) return false;
          }

          if(this.menuUserRole) data = this.role;
          if(this.menuUsers) data = this.user;
          if(this.menuExpenseCategory) data = this.expenseCategory;
          if(this.menuExpenses) data = this.expense;
          data.id = this.id;

          this.alerts.danger.message = '';
          this.alerts.primary.message = '';
          this.alerts.success.message = '';
          
          this.showLoader = true;
          this.showModal = false;
          axios
            .post('/api'+window.location.pathname, data)
            .then(response => {
              if('message' in response.data)
              {
                this.alerts.danger.message = response.data.message;
                this.showModal = true;
              }
              else
              {
                this.id = null;
                this.user.name = '';
                this.user.email = '';
                this.user.role = '';
                this.role.name = '';
                this.role.description = '';
                this.expenseCategory.name = '';
                this.expenseCategory.description = '';
                this.expense.category = '';
                this.expense.amount = '';
                this.expense.entryDate = '';

                this.alerts.success.message = 'Record was successfully saved!';
                
                if(this.menuUserRole) this.data.userRoles = response.data;
                if(this.menuUsers) this.data.users = response.data;
                if(this.menuExpenseCategory) this.data.expenseCategories = response.data;
                if(this.menuExpenses) this.data.expenses = response.data;

                this.showModal = false;
              }

              this.showLoader = false;
            })
            .catch(err => {
              console.log(err.message);
              this.showLoader = false;
              this.showModal = true;
            });
        },
        deleteRecord(){
          this.showLoader = true;
          this.showModal = false;

          this.alerts.danger.message = '';
          this.alerts.primary.message = '';
          this.alerts.success.message = '';

          axios
            .post('/api'+window.location.pathname+'/delete', { 'id': this.id })
            .then(response => {
              if('message' in response.data)
              {
                this.alerts.danger.message = response.data.message;
                this.showModal = true;
              }
              else
              {
                this.id = null;
                this.user.name = '';
                this.user.email = '';
                this.user.role = '';
                this.role.name = '';
                this.role.description = '';
                this.expenseCategory.name = '';
                this.expenseCategory.description = '';
                this.expense.category = '';
                this.expense.amount = '';
                this.expense.entryDate = '';

                this.alerts.primary.message = 'Record was successfully deleted!';
                
                if(this.menuUserRole) this.data.userRoles = response.data;
                if(this.menuUsers) this.data.users = response.data;
                if(this.menuExpenseCategory) this.data.expenseCategories = response.data;
                if(this.menuExpenses) this.data.expenses = response.data;
                this.showModal = false;
              }
              this.showLoader = false;
            })
            .catch(err => {
              console.log(err.message);
              this.showModal = true;
              this.showLoader = false;
            });
        }
    },
    mounted(){
      axios.get('/api/user')
        .then(response => {
          this.isAdmin = response.data.role == 1;
          this.profile.name = response.data.name;
          this.profile.role = response.data.role_name;
        })
        .catch(err => console.log(err.message));

      if(this.menuUsers || this.menuUserRole) this.getUserRoles();
      if(this.menuUsers) this.getUsers();

      if(this.menuExpenses || this.menuExpenseCategory) this.getExpenseCategory();
      if(this.menuExpenses) this.getExpenses();

    },
});

app.mount('#app');

am4core.useTheme(am4themes_animated);

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