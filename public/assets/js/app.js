var one = new Vue({
  el: '#program-content',
  data: {
    categories:[
      { id_cat: '1', category : 'Profesi Kepelatihan'},
      { id_cat: '2', category : 'Praktisi Sumber Daya Manusia'},
      { id_cat: '3', category : 'Profesi UMKM'},
      { id_cat: '4', category : 'Profesi Teknologi Digital'}
    ],
    items: [
      { id : '1', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Klaster Pelaksanaan Pelatihan Tatap Muka',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',        
        category: '1',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '2', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Kualifikasi 3 Junior Instruktur',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '1',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '3', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Kualifikasi 4 Instruktur',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '1',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '4', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Staf Sumberdaya Manusia (SSDM)',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '2',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '5', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Supervisor Pelatihan dan Pengembangan Sumber Daya Manusia (SPPSDM)',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '2',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '6', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Manajer Sumber Daya Manusia (MSDM)',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '2',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '7', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Pengelola UMKM',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '3',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '8', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Pendamping UMKM',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '3',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '9', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Fasilitator Diklat UMKM',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '3',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '10', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Digital Marketing',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '4',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '11', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Operator Komputer Muda',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '4',
        author: 'John Seno',
        date : '15 April 2021'
      },
      { id : '12', 
        img : 'assets/images/program/thumbnail.png',
        subtitle: 'Desainer Grafis Muda',
        content : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        category: '4',
        author: 'John Seno',
        date : '15 April 2021'
      }
    ]
  }
});