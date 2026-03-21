

const RECIPES = [
  {
    id: 1,
    name: "Avocado Egg Toast",
    category: "breakfast",
    tags: ["vegan", "quick"],
    time: 10,
    servings: 1,
    desc: "Creamy avocado on toasted sourdough with a perfectly fried egg and chilli flakes.",
    img: "images/avocado-egg-toast.jpg",
    ingredients: ["2 slices sourdough bread", "1 ripe avocado", "2 eggs", "Pinch of chilli flakes", "Salt & pepper to taste", "1 tsp lemon juice", "Fresh parsley (optional)"],
    steps: ["Toast the sourdough slices until golden and crispy.", "Mash the avocado in a bowl with lemon juice, salt, and pepper.", "Fry the eggs in a non-stick pan with a little oil to your liking.", "Spread the avocado mash generously on each toast.", "Place a fried egg on top, sprinkle with chilli flakes and parsley.", "Serve immediately while warm."]
  },
  {
    id: 2,
    name: "Banana Oat Pancakes",
    category: "breakfast",
    tags: ["vegan", "quick"],
    time: 15,
    servings: 2,
    desc: "Fluffy, naturally sweet pancakes made with just bananas and oats — no flour needed.",
    img: "images/banana-oat-pancakes.jpg",
    ingredients: ["2 ripe bananas", "1 cup rolled oats", "2 eggs", "1 tsp baking powder", "1/2 tsp cinnamon", "Pinch of salt", "Maple syrup & berries to serve"],
    steps: ["Blend oats until they form a fine flour.", "Mash bananas in a bowl, then add eggs, oat flour, baking powder, and cinnamon.", "Mix until a smooth batter forms — it will be thick.", "Heat a non-stick pan over medium heat with a small amount of butter.", "Pour small rounds of batter and cook 2–3 minutes per side until golden.", "Serve with maple syrup and fresh berries."]
  },
  {
    id: 3,
    name: "Greek Yogurt Bowl",
    category: "breakfast",
    tags: ["quick", "vegan"],
    time: 5,
    servings: 1,
    desc: "A protein-packed bowl with creamy yogurt, crunchy granola, and fresh seasonal fruits.",
    img: "images/greek-yogurt-bowl.jpg",
    ingredients: ["200g Greek yogurt", "3 tbsp granola", "1 banana, sliced", "Handful of strawberries", "1 tbsp honey", "1 tsp chia seeds"],
    steps: ["Spoon the Greek yogurt into a bowl.", "Arrange banana slices and strawberries on top.", "Sprinkle granola and chia seeds evenly.", "Drizzle honey over everything.", "Serve fresh and enjoy immediately."]
  },
  {
    id: 4,
    name: "Chicken Caesar Wrap",
    category: "lunch",
    tags: ["quick"],
    time: 15,
    servings: 1,
    desc: "A satisfying grilled chicken wrap with crispy romaine, parmesan, and creamy Caesar dressing.",
    img: "images/chicken-caesar-wrap.jpg",
    ingredients: ["1 large flour tortilla", "150g grilled chicken breast, sliced", "2 romaine lettuce leaves, shredded", "2 tbsp Caesar dressing", "1 tbsp grated parmesan", "Croutons (optional)", "Black pepper"],
    steps: ["Warm the tortilla in a dry pan for 30 seconds each side.", "Lay the grilled chicken slices down the centre.", "Top with shredded romaine lettuce and croutons.", "Drizzle Caesar dressing and sprinkle parmesan.", "Season with black pepper.", "Fold the sides in and roll up tightly. Slice in half and serve."]
  },
  {
    id: 5,
    name: "Vegan Buddha Bowl",
    category: "lunch",
    tags: ["vegan"],
    time: 25,
    servings: 2,
    desc: "A nourishing bowl of roasted veggies, quinoa, chickpeas and tahini dressing.",
    img: "images/vegan-buddha-bowl.jpg",
    ingredients: ["1 cup quinoa", "1 can chickpeas, drained", "1 sweet potato, cubed", "1 cup broccoli florets", "2 tbsp olive oil", "1 tsp paprika", "2 tbsp tahini", "1 lemon, juiced", "Salt & pepper"],
    steps: ["Preheat oven to 200°C. Toss sweet potato and broccoli with olive oil and paprika.", "Roast vegetables for 20 minutes until tender.", "Meanwhile, cook quinoa as per packet instructions.", "Mix tahini with lemon juice, a pinch of salt, and 2 tbsp water to make dressing.", "Assemble bowls: quinoa base, roasted veggies, chickpeas.", "Drizzle tahini dressing on top and serve."]
  },
  {
    id: 6,
    name: "Tomato Basil Pasta",
    category: "lunch",
    tags: ["vegan", "quick"],
    time: 20,
    servings: 2,
    desc: "Simple, classic Italian pasta with a fresh cherry tomato sauce and fragrant basil.",
    img: "images/tomato-basil-pasta.jpg",
    ingredients: ["200g spaghetti", "200g cherry tomatoes, halved", "3 garlic cloves, minced", "3 tbsp olive oil", "Handful of fresh basil", "Salt & black pepper", "Parmesan to serve (optional)"],
    steps: ["Cook spaghetti in salted boiling water until al dente. Reserve ½ cup pasta water.", "Heat olive oil in a pan over medium heat. Add garlic and sauté 1 minute.", "Add cherry tomatoes, season with salt and pepper, cook for 8 minutes until saucy.", "Toss in the drained pasta and a splash of pasta water.", "Remove from heat, add fresh basil leaves, and toss.", "Serve with grated parmesan if desired."]
  },
  {
    id: 7,
    name: "Butter Chicken",
    category: "dinner",
    tags: [],
    time: 45,
    servings: 4,
    desc: "Rich, creamy tomato-based curry with tender chicken pieces — a true crowd-pleaser.",
    img: "images/butter-chicken.jpg",
    ingredients: ["500g chicken breast, cubed", "1 can tomato purée", "1 cup heavy cream", "2 tbsp butter", "1 onion, diced", "4 garlic cloves, minced", "1 tsp garam masala", "1 tsp cumin", "1 tsp turmeric", "Salt to taste", "Fresh coriander to garnish"],
    steps: ["Marinate chicken in yogurt, turmeric, and cumin for 15 minutes.", "Melt butter in a large pan. Fry onion and garlic until golden.", "Add chicken and cook until sealed, about 6 minutes.", "Add tomato purée, garam masala, and salt. Simmer 15 minutes.", "Stir in cream and cook for a further 5 minutes.", "Garnish with fresh coriander and serve with rice or naan."]
  },
  {
    id: 8,
    name: "Spaghetti Carbonara",
    category: "dinner",
    tags: ["quick"],
    time: 25,
    servings: 2,
    desc: "The authentic Roman pasta dish with egg, pecorino, guanciale and lots of black pepper.",
    img: "images/spaghetti-carbonara.jpg",
    ingredients: ["200g spaghetti", "100g guanciale or pancetta, diced", "3 large eggs", "50g pecorino romano, grated", "50g parmesan, grated", "Cracked black pepper", "Salt for pasta water"],
    steps: ["Cook spaghetti in well-salted boiling water until al dente. Reserve 1 cup pasta water.", "Fry guanciale in a dry pan over medium heat until crispy. Remove from heat.", "Whisk eggs with grated pecorino and parmesan. Add generous black pepper.", "Drain pasta and immediately toss with guanciale off the heat.", "Pour egg mixture over pasta, adding pasta water gradually to make it creamy.", "Serve immediately with extra cheese and black pepper."]
  },
  {
    id: 9,
    name: "Veggie Stir Fry",
    category: "dinner",
    tags: ["vegan", "quick"],
    time: 20,
    servings: 2,
    desc: "A vibrant, colourful wok-tossed stir fry with seasonal vegetables and soy-ginger sauce.",
    img: "images/veggie-stir-fry.jpg",
    ingredients: ["2 cups mixed vegetables (bell pepper, carrot, broccoli, snap peas)", "2 tbsp soy sauce", "1 tbsp sesame oil", "1 tbsp fresh ginger, grated", "3 garlic cloves, minced", "1 tsp cornstarch mixed in 2 tbsp water", "Cooked rice to serve", "Sesame seeds to garnish"],
    steps: ["Heat sesame oil in a wok or large frying pan over high heat.", "Add garlic and ginger; stir fry for 30 seconds.", "Add harder vegetables (carrot, broccoli) first; cook 3 minutes.", "Add softer vegetables (bell pepper, snap peas); cook 2 more minutes.", "Pour soy sauce and cornstarch mixture over. Toss until sauce thickens.", "Serve over rice and garnish with sesame seeds."]
  },
  {
    id: 10,
    name: "Mushroom Risotto",
    category: "dinner",
    tags: ["vegan"],
    time: 40,
    servings: 3,
    desc: "Luxuriously creamy Italian risotto loaded with earthy mushrooms and fresh herbs.",
    img: "images/mushroom-risotto.jpg",
    ingredients: ["300g arborio rice", "400g mixed mushrooms, sliced", "1L warm vegetable stock", "1 onion, finely diced", "3 garlic cloves", "100ml white wine", "3 tbsp butter", "50g parmesan", "Fresh thyme", "Salt & pepper"],
    steps: ["Sauté onion and garlic in 2 tbsp butter until soft. Add mushrooms and cook until golden.", "Add rice and toast for 2 minutes, stirring constantly.", "Pour in wine and stir until absorbed.", "Add warm stock one ladle at a time, stirring between each addition — about 20 minutes.", "When rice is creamy and cooked, remove from heat.", "Stir in remaining butter and parmesan. Season and garnish with fresh thyme."]
  },
  {
    id: 11,
    name: "Egg Fried Rice",
    category: "lunch",
    tags: ["quick"],
    time: 12,
    servings: 2,
    desc: "Quick and satisfying fried rice with scrambled egg, spring onion, and soy sauce.",
    img: "images/egg-fried-rice.jpg",
    ingredients: ["2 cups cooked rice (day-old is best)", "2 eggs, beaten", "3 tbsp soy sauce", "1 tbsp sesame oil", "2 spring onions, sliced", "2 garlic cloves, minced", "1 cup frozen peas"],
    steps: ["Heat sesame oil in a wok over high heat.", "Add garlic and stir fry 30 seconds.", "Push rice to one side; scramble eggs on the other side.", "Mix eggs through the rice once cooked.", "Add frozen peas and soy sauce. Toss everything together.", "Garnish with spring onions and serve hot."]
  },
  {
    id: 12,
    name: "Overnight Chia Pudding",
    category: "breakfast",
    tags: ["vegan", "quick"],
    time: 5,
    servings: 1,
    desc: "A prep-ahead, no-cook breakfast that's creamy, nutritious, and endlessly customisable.",
    img: "images/overnight-chia-pudding.jpg",
    ingredients: ["3 tbsp chia seeds", "1 cup almond milk", "1 tbsp maple syrup", "1/2 tsp vanilla extract", "Toppings: mango, kiwi, granola"],
    steps: ["Mix chia seeds, almond milk, maple syrup, and vanilla in a jar.", "Stir well to combine — make sure no seeds clump.", "Cover and refrigerate overnight (or at least 4 hours).", "In the morning, stir once more to loosen.", "Top with fresh fruit and granola before serving."]
  }
];
