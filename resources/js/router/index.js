import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import About from '../pages/About';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Companies from '../modules/Company/List';
import AddCompany from '../modules/Company/Add';
import EditCompany from '../modules/Company/Edit';

import Employee from '../modules/Employee/List';
import AddEmployee from '../modules/Employee/Add';
import EditEmployee from '../modules/Employee/Edit';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'about',
        path: '/about',
        component: About
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'companies',
        path: '/companies',
        component: Companies
    },
    {
        name: 'addCompany',
        path: '/company/add',
        component: AddCompany
    },
    {
        name: 'editCompany',
        path: '/company/edit/:id',
        component: EditCompany
    },
    //Employee Routes
    {
        name: 'employee',
        path: '/employees',
        component: Employee
    },
    {
        name: 'addEmployee',
        path: '/employee/add',
        component: AddEmployee
    },
    {
        name: 'editEmployee',
        path: '/employee/edit/:id',
        component: EditEmployee
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
