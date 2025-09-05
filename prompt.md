# Contexto

Voce é um desenvolvedor PHP/Laravel e Vuejs experiente, possui um bom conhecimento
em marketing digital, UX/UI.

# Objetivo

Criar uma aplicação web, baseada em docker para desenvolvimento, que deverá ser um assistente
de criação de fichas de academias, podendo ser utilizada em várias academias e que essas academias
possuem várias filiais.
integrada a uma inteligencia artificial de preferencia o gemini do google, que sugere os exercicios
baseado nos aparelhos encontrados na academia, previamente cadastrados, dados dos alunos
(altura, historico de peso e medidas), comorbidades - caso tenha sido cadastrado.

# Style

Para o estilo utilize a biblioteca tailwind e para as cores utilize grafite e roxo como cores principais
e como cores secundárias branco e cinza. Utilize uma tipografia que seja condizente com o assunto da aplicação.

# Audiencia

1. Menu de navegação entre as páginas.
2. CRUD das informações dos alunos
3. Página da ficha, deverá ser um formulário com as informações da ficha que está integrada a IA baseado no
   prompt <prompt>.
    1. Para que a sugestão aconteça o usuário deverá clicar no botão sugerir exercĩcios, que deve estar destacado na
       tela.
    2. As informações da ficha sugerida pela IA poderão ser editadas pelo usuário e confirmadas ao final.
4. A integração da IA leva em consideração o prompt <prompt> e deve ser feito no backend ajustando os dados que estão
   entre
   colchetes.

<prompt>
Aja como um personal trainer experiente e crie uma ficha de treino completa para um aluno, considerando as informações abaixo.

**Informações do Aluno:**

- **Nome:** [Nome do Aluno]
- **Idade:** [Idade do Aluno]
- **Objetivo Principal:** [Ex: Hipertrofia, emagrecimento, força, resistência, reabilitação, etc.]
- **Nível de Experiência:** [Ex: Iniciante, Intermediário, Avançado]
- **Frequência de Treino:** [Ex: 3x por semana, 5x por semana]
- **Equipamentos Disponíveis:
  ** [Ex: Peso livre, máquinas, elásticos, halteres, etc. Se for em uma academia, apenas cite "Academia completa".]
- **Condições de Saúde/Lesões:** [Ex: Dor no joelho, problema na coluna, etc. Se não houver, escreva "Nenhuma".]

**Histórico de Treino:**

- **Exercícios já executados/preferidos:** [Liste os exercícios que o aluno já faz ou gosta.]
- **Exercícios a evitar:** [Liste exercícios que o aluno não gosta ou que causam desconforto.]
- **Treino anterior:
  ** [Descreva o treino que o aluno estava fazendo. Ex: Treino A/B/C, treino focado em pernas e glúteos.]

**Instruções para a Ficha de Treino:**

- Crie um treino dividido em [Número] dias, com uma divisão de grupos musculares clara (Ex: Treino A - Peito e Tríceps,
  Treino B - Costas e Bíceps).
- Para cada exercício, inclua:
    - **Nome do Exercício:**
    - **Séries:**
    - **Repetições:**
    - **Observações:** (Ex: "Aumente a carga progressivamente", "Movimento controlado", "Descanso de 60 segundos entre
      as séries").
- Inclua uma rotina de aquecimento e alongamento ao final.
- Garanta que o treino seja seguro e eficiente para o objetivo e nível do aluno.
- Sugira a progressão de carga ou dificuldade para as próximas semanas.
  </prompt>
