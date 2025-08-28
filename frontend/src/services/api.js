import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api';

export const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

export const operationService = {
  getAll: () => api.get('/operations'),
  create: (operation) => api.post('/operations', operation),
};

export const categoryService = {
  getAll: () => api.get('/categories'),
  create: (category) => api.post('/categories', category),
};