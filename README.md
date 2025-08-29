# MyBank - Expense Management Application

Application de gestion des dépenses développée 

## Statut du projet
- ✅ Backend Symfony avec API REST
- ✅ Frontend React avec interface utilisateur
- ✅ Base de données MySQL containerisée
- ✅ Docker et Docker Compose configurés
- ✅ Versioning Git/GitHub
- ✅ Documentation de déploiement
- ⚠️ CI/CD GitHub Actions (en cours)

## Fonctionnalités implémentées
- Affichage des dépenses
- Ajout de nouvelles dépenses
- Suppression des dépenses
- Catégorisation
- Interface responsive

## Démarrage rapide
```bash
git clone https://github.com/UniversMood/mybank-project.git
cd mybank-project
docker-compose up backend database -d
cd frontend && npm install && npm run dev
