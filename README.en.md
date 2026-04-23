# JisuCMS (极速CMS)

<p align="center">
  <strong>Lightweight, High-Performance PHP Content Management System</strong>
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#quick-start">Quick Start</a> •
  <a href="#requirements">Requirements</a> •
  <a href="#documentation">Documentation</a> •
  <a href="README.md">中文文档</a>
</p>

---

## 📋 Project Information

- **Current Version**: v1.0.0
- **Release Date**: 2026-04-23
- **License**: MIT License
- **Official Website**: [www.jisucms.com](https://www.jisucms.com)
- **Tech Stack**: PHP & MySQL
- **Core Framework**: XiunoPHP

---

## 💡 Introduction

JisuCMS (极速CMS) is a lightweight, high-performance content management system built on the XiunoPHP framework. Using PHP & MySQL architecture, it's designed for websites handling tens of millions of data records with exceptional performance and flexible extensibility.

### Why Choose JisuCMS?

- 🚀 **Extreme Performance** - Supports billions of records per table with lazy loading design
- 🔌 **Powerful Plugins** - AOP plugin mechanism with zero performance overhead
- 🎨 **Simple & Clean** - Core features only, everything else via plugins
- 📱 **Responsive Admin** - Works on desktop, tablet, and mobile devices
- 🔍 **SEO Friendly** - Flexible URL configuration for better search engine indexing
- 💰 **Completely Free** - MIT License, no authorization needed for commercial use

---

## 🎯 Features

### Core Capabilities

#### 1. High-Performance Architecture
- Lazy loading mechanism
- Distributed server design
- Supports billions of records per table
- Powerful caching technology

#### 2. Flexible Plugin System
- AOP (Aspect-Oriented Programming) plugin mechanism
- Zero performance overhead
- Powerful HOOK functionality
- Easy feature extension

#### 3. Convenient Template System
- Efficient and concise template tags
- Only HTML and CSS knowledge required
- Low cost and short development cycle
- Custom theme support

#### 4. Responsive Admin Panel
- Built with Layui + LayuiMini
- Perfect adaptation for all devices
- Clean and beautiful interface
- Excellent user experience

#### 5. Powerful SEO Features
- Multiple built-in SEO settings
- Flexible URL path configuration
- Pseudo-static support
- Custom SEO rules

#### 6. Custom Content Models
- Support for custom models (via plugin)
- Custom field extension
- Suitable for different business scenarios
- Separate table storage for millions of records

---

## 🚀 Quick Start

### Requirements

| Environment | Minimum | Recommended |
|------------|---------|-------------|
| PHP | 5.5+ | 7.0+ |
| MySQL | 5.0+ | 5.7+ |
| Web Server | Apache/Nginx | Nginx |
| PHP Extensions | mysql/mysqli/pdo_mysql | mysqli |

### Installation Steps

1. **Download Source Code**
   ```bash
   git clone https://github.com/yourusername/jisucms.git
   cd jisucms
   ```

2. **Configure Web Server**
   - Point web root to project directory
   - Ensure `jisucms/config/` is writable
   - Ensure `upload/` is writable

3. **Run Installation**
   - Visit `http://yourdomain/install/`
   - Follow the installation wizard
   - Configure database and admin account

4. **Complete Installation**
   - Delete `install/` directory (Important!)
   - Access admin panel: `http://yourdomain/admin/`
   - Start using JisuCMS

### URL Rewrite Configuration

#### Nginx
```nginx
location / {
    if (!-e $request_filename) {
        rewrite ^(.*)$ /index.php?$1 last;
    }
}
```

#### Apache
Create `.htaccess` in web root:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?$1 [QSA,PT,L]
</IfModule>
```

---

## 📚 Documentation

### Official Resources

- 📖 [User Guide](https://www.jisucms.com/docs)
- 🎨 [Template Development](https://www.jisucms.com/template)
- 🔌 [Plugin Development](https://www.jisucms.com/plugin)
- 💬 [FAQ](https://www.jisucms.com/faq)

### Directory Structure

```
jisucms/
├── admin/              # Admin panel directory
│   ├── control/        # Admin controllers
│   └── view/           # Admin views
├── install/            # Installation program (delete after install)
├── jisucms/            # Core program directory
│   ├── block/          # Template tags
│   ├── config/         # Configuration files
│   ├── control/        # Frontend controllers
│   ├── lang/           # Language packs
│   ├── model/          # Data models
│   ├── plugin/         # Plugins directory
│   └── xiunophp/       # XiunoPHP framework
├── static/             # Static resources
├── upload/             # Upload directory
├── view/               # Frontend theme directory
│   └── default/        # Default theme
├── index.php           # Entry file
└── README.md           # Documentation
```

---

## 🌟 Core Advantages

### Performance

- ⚡ **Lightning Fast** - Optimized code structure, millisecond response
- 📊 **Big Data Support** - Handles billions of records per table
- 🔄 **Smart Caching** - Multi-level caching reduces database queries
- 🚀 **High Concurrency** - Supports distributed deployment

### Developer Experience

- 🎯 **Easy to Use** - Clear code structure, easy to understand
- 🔧 **Flexible Extension** - Powerful plugin and hook system
- 📝 **Standard Code** - Follows PSR standards
- 🛠️ **Secondary Development** - Complete documentation

### Security & Reliability

- 🔒 **Security Protection** - Built-in XSS, SQL injection protection
- 🔑 **Permission Management** - Complete user permission system
- 📋 **Data Backup** - Database backup and recovery support
- 🔐 **Encrypted Storage** - Sensitive data encryption

---

## 👥 Community

### Join Us

- 🌐 **Official Website**: [www.jisucms.com](https://www.jisucms.com)
- 💬 **QQ Group**: TBD (Welcome to join)
- 📧 **Issue Tracker**: [GitHub Issues](https://github.com/yourusername/jisucms/issues)
- 📖 **Documentation**: [www.jisucms.com/docs](https://www.jisucms.com/docs)

### Contributing

We welcome all forms of contribution:

1. 🐛 **Report Bugs** - Submit issues describing problems
2. 💡 **Feature Requests** - Share your ideas and suggestions
3. 📝 **Improve Documentation** - Help improve documentation
4. 💻 **Submit Code** - Fork and submit Pull Requests

#### Contribution Steps

```bash
# 1. Fork the repository
# 2. Create feature branch
git checkout -b feature/AmazingFeature

# 3. Commit changes
git commit -m 'Add some AmazingFeature'

# 4. Push to branch
git push origin feature/AmazingFeature

# 5. Submit Pull Request
```

---

## 🙏 Special Thanks

JisuCMS is built upon these excellent open source projects:

- **[XiunoPHP](https://github.com/xiuno/xiunophp)** - Lightweight PHP framework
- **[Layui](https://layui.dev/)** - Classic modular frontend UI framework
- **[LayuiMini](http://layuimini.99php.cn/)** - Admin template based on Layui
- **[LeCMS](https://www.lecms.cc)** - Original project that provided the foundation

Thanks to all developers contributing to the open source community!

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

This means you can:

- ✅ Commercial use
- ✅ Modify source code
- ✅ Distribution
- ✅ Private use

The only requirement:

- 📋 Retain copyright and license notices

---

## 📮 Contact

- **Official Website**: [www.jisucms.com](https://www.jisucms.com)
- **Technical Support**: Available through official website
- **Business Cooperation**: Contact through official website

---

## 🗺️ Roadmap

### v1.0.0 (Current)
- ✅ Complete brand rebranding
- ✅ Stable core features
- ✅ Basic plugin support
- ✅ Responsive admin panel

### v1.1.0 (Planned)
- 🔄 Performance optimization
- 🔄 Plugin marketplace
- 🔄 Theme marketplace
- 🔄 Online updates

### v1.2.0 (Planned)
- 📅 API interface
- 📅 Mobile optimization
- 📅 Multi-language support
- 📅 More plugins

### v2.0.0 (Long-term)
- 🎯 Architecture upgrade
- 🎯 Frontend-backend separation
- 🎯 Microservices support
- 🎯 Cloud-native deployment

---

<p align="center">
  <strong>If this project helps you, please give us a ⭐ Star!</strong>
</p>

<p align="center">
  Made with ❤️ by JisuCMS Team
</p>

<p align="center">
  Copyright © 2026 <a href="https://www.jisucms.com">JisuCMS</a>
</p>
