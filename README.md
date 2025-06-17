# Transfert Management Platform

Plateforme web de gestion et de suivi des demandes de transfert universitaire développée avec Laravel.

---

## 📋 Présentation

La **Transfert Management Platform** est une application Laravel permettant aux étudiants de déposer, suivre et gérer leurs demandes de transfert entre universités. Les administrateurs disposent d'outils puissants pour centraliser et traiter efficacement ces dossiers.

---

## 🌟 Fonctionnalités principales

- **Authentification sécurisée** : Gestion des étudiants et des administrateurs via le système natif de Laravel.
- **Dépôt de dossier en ligne** : Formulaires clairs pour la soumission des documents nécessaires.
- **Suivi en temps réel** : Visualisation de l’état d’avancement du dossier (nouveau, en cours, accepté, refusé, etc.).
- **Notifications** : Alertes par email intégrées (Laravel Notifications).
- **Tableau de bord administratif** : Gestion des demandes, recherche, filtrage, statistiques.
- **Historique complet** : Journalisation des actions sur chaque dossier.
- **Sécurité** : Middleware, validation, et protection des données utilisateurs.

---

## 🏗️ Stack technique

- **Framework** : [Laravel](https://laravel.com/) (PHP)
- **Base de données** : MySQL / MariaDB / PostgreSQL
- **Front-end** : Blade, Bootstrap/Tailwind, Livewire ou Vue.js (optionnel)
- **Authentification** : Laravel Breeze/Jetstream/Fortify (au choix)
- **Notifications** : Laravel Notifications (email, éventuellement SMS)
- **Outils supplémentaires** : Laravel Excel (export), Spatie Permissions (gestion des rôles), etc.

---

## 🖥️ Structure du projet

```
Transfert-Management-Platform/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
│   ├── views/
├── routes/
├── storage/
├── tests/
├── .env.example
├── composer.json
├── README.md
└── ...
```

---

## 🚀 Installation

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/djeddiouael/Transfert-Management-Platform.git
   cd Transfert-Management-Platform
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configurer l’environnement**
   - Copier `.env.example` en `.env`
   - Configurer la base de données, mail, etc.

4. **Générer la clé d’application**
   ```bash
   php artisan key:generate
   ```

5. **Lancer les migrations et seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Démarrer le serveur**
   ```bash
   php artisan serve
   ```
   Accéder à [http://localhost:8000](http://localhost:8000)

---

## 📄 Cas d’utilisation

### Étudiant
- S’inscrire ou se connecter
- Remplir et déposer une demande de transfert avec pièces jointes
- Suivre l’évolution de sa demande dans le tableau de bord
- Recevoir des notifications par email

### Administration
- Se connecter en tant qu’admin
- Voir et gérer toutes les demandes
- Filtrer, trier, accepter/refuser les dossiers
- Exporter les listes/statistiques

---

## ✅ Bonnes pratiques & sécurité

- **Validation forte des formulaires** avec les règles Laravel
- **Protection CSRF/XSS** native à Laravel
- **Gestion des rôles et permissions** (Spatie Permissions recommandé)
- **Stockage sécurisé des fichiers** dans `/storage`
- **Respect de la confidentialité** (RGPD)

---

## 🤝 Contribution

1. Forkez ce dépôt
2. Créez une branche (`git checkout -b feature/NouvelleFonctionnalite`)
3. Commitez vos modifications (`git commit -am 'Ajout d'une nouvelle fonctionnalité'`)
4. Pushez la branche (`git push origin feature/NouvelleFonctionnalite`)
5. Ouvrez une Pull Request

---

## 📝 Licence

Ce projet est sous licence MIT.
